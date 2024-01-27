<?php

namespace App\Entity;

use App\Repository\GenerationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenerationRepository::class)]
class Generation
{
    #[ORM\Id]
    #[ORM\Column(length: 10)]
    private ?string $id = null;

    #[ORM\Column(length: 2)]
    private ?string $numero = null;

    #[ORM\Column(length: 4)]
    private ?string $annee = null;

    #[ORM\OneToMany(mappedBy: 'generation', targetEntity: Pokemon::class)]
    private Collection $pokemons;

    public function __construct(string $id = null, string $numero = null, string $annee = null)
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->annee = $annee;
        $this->pokemon = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): static
    {
        $this->annee = $annee;

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
            $pokemons->setGeneration($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): static
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getGeneration() === $this) {
                $pokemon->setGeneration(null);
            }
        }

        return $this;
    }
}
