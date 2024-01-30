<?php

namespace App\Entity;

use App\Enums\StatusEnum as Status;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 25, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 25)]
    private ?string $nomUtilisateur = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private ?string $password = 'password';

    private ?string $plainPassword = null;

    #[ORM\Column(type: 'string', length: 150, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    #[Assert\Length(min: 10, max: 150)]
    private ?string $email;

    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $dateInscription = null;

    #[ORM\Column]
    private ?Status $status = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Dresseur::class, cascade: ['persist', 'remove'])]
    private Collection $dresseurs;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isSubscribedNewsletter = null;

    public function __construct()
    {
        $this->dateInscription = new \DateTimeImmutable();
        $this->status = Status::EN_ATTENTE_DE_VALIDATION;
        $this->roles = ['ROLE_USER'];
        $this->dresseurs = new ArrayCollection();
    }

    public function inscritDepuis(): string
    {
        $now = new \DateTimeImmutable();
        $diff = $now->diff($this->dateInscription);
        $str = '';

        if ($diff->y > 0) {
            $str .= $diff->y.' an';
            if ($diff->y > 1) {
                $str .= 's';
            }
        }

        if ($diff->m > 0) {
            $str .= ' '.$diff->m.' mois';
        }

        if ($diff->d > 0) {
            $str .= ' '.$diff->d.' jour';
            if ($diff->d > 1) {
                $str .= 's';
            }
        }

        return $str;
    }

    public function dateInscriptionFormatee(): string
    {
        // "Inscrit depuis le jj/mm/aaaa (inscritDepuis())"
        return 'Inscrit depuis le '.$this->dateInscription->format('d/m/Y').' ('.$this->inscritDepuis().')';
    }

    public function dateHeureInscription(): string
    {
        return $this->dateInscription->format('d/m/Y H:i');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): static
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of plainPassword.
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword.
     *
     * @return self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): static
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeImmutable $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDresseurs(): Collection
    {
        return $this->dresseurs;
    }

    public function setDresseurs(Collection $dresseurs): static
    {
        return $this->dresseurs = $dresseurs;
    }

    public function addDresseur(Dresseur $dresseur): static
    {
        if (!$this->dresseurs->contains($dresseur)) {
            $this->dresseurs->add($dresseur);
            $dresseur->setUser($this);
        }

        return $this;
    }

    public function removeDresseur(Dresseur $dresseur): static
    {
        if ($this->dresseurs->contains($dresseur)) {
            $this->dresseurs->removeElement($dresseur);
            $dresseur->setUser(null);
        }

        return $this;
    }

    public function getIsSubscribedNewsletter(): ?bool
    {
        return $this->isSubscribedNewsletter;
    }

    public function setIsSubscribedNewsletter($isSubscribedNewsletter): static
    {
        $this->isSubscribedNewsletter = $isSubscribedNewsletter;

        return $this;
    }
}
