<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4, unique: true)]
    private ?string $numero = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $image = null;

    #[ORM\Column(length: 50)]
    private ?string $miniImage = null;

    #[ORM\ManyToMany(targetEntity: Dresseur::class, inversedBy: 'pokemons')]
    private Collection $dresseurs;

    #[ORM\ManyToOne(inversedBy: 'pokemons')]
    private ?Generation $generation = null;

    #[ORM\ManyToMany(targetEntity: Type::class, inversedBy: 'pokemons')]
    #[ORM\JoinTable(name: 'pokemon_type')]
    private Collection $types;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Stats $stats = null;

    #[ORM\ManyToOne(inversedBy: 'pokemons')]
    private ?Consommable $consommable = null;

    #[ORM\ManyToMany(targetEntity: Attaque::class, inversedBy: 'pokemons')]
    #[ORM\JoinTable(name: 'pokemon_attaque')]
    private Collection $attaques;

    public function __construct(string $numero = null, string $nom = null, string $image = null, string $miniImage = null)
    {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->image = $image;
        $this->miniImage = $miniImage;
        $this->dresseurs = new ArrayCollection();
        $this->types = new ArrayCollection();
        $this->attaques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getMiniImage(): ?string
    {
        return $this->miniImage;
    }

    public function setMiniImage(string $miniImage): static
    {
        $this->miniImage = $miniImage;

        return $this;
    }

    /**
     * @return Collection<int, Dresseur>
     */
    public function getDresseurs(): Collection
    {
        return $this->dresseurs;
    }

    public function addDresseur(Dresseur $dresseur): static
    {
        if (!$this->dresseurs->contains($dresseur)) {
            $this->dresseurs->add($dresseur);
            $dresseur->addPokemon($this);
        }

        return $this;
    }

    public function removeDresseur(Dresseur $dresseur): static
    {
        if ($this->dresseurs->removeElement($dresseur)) {
            $dresseur->removePokemon($this);
        }

        return $this;
    }

    public function getGeneration(): ?generation
    {
        return $this->generation;
    }

    public function setGeneration(?generation $generation): static
    {
        $this->generation = $generation;

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(Type $type): static
    {
        $this->types->removeElement($type);

        return $this;
    }

    public function getStats(): ?stats
    {
        return $this->stats;
    }

    public function setStats(?stats $stats): static
    {
        $this->stats = $stats;

        return $this;
    }

    public function getConsommable(): ?consommable
    {
        return $this->consommable;
    }

    public function setConsommable(?consommable $consommable): static
    {
        $this->consommable = $consommable;

        return $this;
    }

    /**
     * @return Collection<int, Attaque>
     */
    public function getAttaques(): Collection
    {
        return $this->attaques;
    }

    public function addAttaque(Attaque $attaque): static
    {
        if (!$this->attaques->contains($attaque)) {
            $this->attaques->add($attaque);
        }

        return $this;
    }

    public function removeAttaque(Attaque $attaque): static
    {
        $this->attaques->removeElement($attaque);

        return $this;
    }
}
