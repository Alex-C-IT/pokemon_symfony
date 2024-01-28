<?php

namespace App\Entity;

use App\Repository\DresseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DresseurRepository::class)]
class Dresseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Le nom du dresseur est unique
    #[ORM\Column(length: 25, unique: true)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $taille = null;

    #[ORM\Column]
    private ?bool $sexe = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'dresseurs')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Pokemon::class, mappedBy: 'dresseurs')]
    private Collection $pokemons;

    public function __construct(string $nom = null, int $taille = null, bool $sexe = null, ?string $message = null)
    {
        $this->nom = $nom;
        $this->taille = $taille;
        $this->sexe = $sexe;
        $this->message = $message;
        $this->pokemons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function isSexe(): ?bool
    {
        return $this->sexe;
    }

    public function setSexe(bool $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Pokemon>
     */
    public function getPokemons(): Collection
    {
        return $this->pokemons;
    }

    public function addPokemon(Pokemon $pokemon): static
    {
        if (!$this->pokemons->contains($pokemon)) {
            $this->pokemons->add($pokemon);
            $pokemon->addDresseur($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): static
    {
        if($this->pokemons->removeElement($pokemon)) {
            $pokemon->removeDresseur($this);
        }
        
        return $this;
    }
}
