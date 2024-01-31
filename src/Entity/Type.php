<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $libelle = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Pokemon::class, mappedBy: 'types')]
    private Collection $pokemons;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Attaque::class)]
    private Collection $attaques;

    public function __construct(string $libelle = null)
    {
        $this->libelle = $libelle;
        $this->pokemons = new ArrayCollection();
        $this->attaques = new ArrayCollection();
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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
            $pokemon->addType($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): static
    {
        if ($this->pokemons->removeElement($pokemon)) {
            $pokemons->removeType($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, attaque>
     */
    public function getAttaques(): Collection
    {
        return $this->attaques;
    }

    public function addAttaque(attaque $attaque): static
    {
        if (!$this->attaques->contains($attaque)) {
            $this->attaques->add($attaque);
            $attaque->setType($this);
        }

        return $this;
    }

    public function removeAttaque(attaque $attaque): static
    {
        if ($this->attaques->removeElement($attaque)) {
            // set the owning side to null (unless already changed)
            if ($attaque->getType() === $this) {
                $attaque->setType(null);
            }
        }

        return $this;
    }
}
