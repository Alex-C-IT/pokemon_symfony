<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enums\Status;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nomUtilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\Column]
    private ?Status $status = null;

    #[ORM\Column]
    private ?bool $mailEnvoye = null;

    #[ORM\OneToMany(mappedBy: 'dresseurs', targetEntity: Dresseur::class)]
    private Collection $dresseurs;

    public function __construct(string $nomUtilisateur, string $password, string $email)
    {
        $this->nomUtilisateur = $nomUtilisateur;
        $this->password = $password;
        $this->email = $email;
        // Formatage de la date et l'heure d'inscription actuelle pour MySQL (AAAA-MM-JJ HH:MM:SS)
        $this->dateInscription = new \DateTimeImmutable();
        $this->status = Status::ACTIF;
        $this->mailEnvoye = false;
        $this->dresseurs = new ArrayCollection();
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
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

    public function isMailEnvoye(): ?bool
    {
        return $this->mailEnvoye;
    }

    public function setMailEnvoye(bool $mailEnvoye): static
    {
        $this->mailEnvoye = $mailEnvoye;

        return $this;
    }
}
