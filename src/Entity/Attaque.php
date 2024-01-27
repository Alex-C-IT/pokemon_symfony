<?php

namespace App\Entity;

use App\Repository\AttaqueRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttaqueRepository::class)]
class Attaque
{
    #[ORM\Id]
    #[ORM\Column(length: 10)]
    private ?string $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $puissance = null;

    #[ORM\Column]
    private ?int $prec = null;

    #[ORM\Column]
    private ?int $pp = null;

    #[ORM\Column]
    private ?bool $cs = null;

    // N'est pas unique. Un type peut être utilisé par plusieurs attaques
    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'attaques')]
    private ?Type $type = null;

    #[ORM\ManyToMany(targetEntity: Pokemon::class, mappedBy: 'attaques')]
    private Collection $pokemons;

    public function __construct(string $id = null, string $nom = null, string $description = null, int $puissance = null, int $prec = null, int $pp = null, bool $cs = null, ?Type $type = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->puissance = $puissance;
        $this->prec = $prec;
        $this->pp = $pp;
        $this->cs = $cs;
        if($type != null)
            $this->type = $type;
        $this->pokemons = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): static
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getPrec(): ?int
    {
        return $this->prec;
    }

    public function setPrec(int $prec): static
    {
        $this->prec = $prec;

        return $this;
    }

    public function getPp(): ?int
    {
        return $this->pp;
    }

    public function setPp(int $pp): static
    {
        $this->pp = $pp;

        return $this;
    }

    public function isCs(): ?bool
    {
        return $this->cs;
    }

    public function setCs(bool $cs): static
    {
        $this->cs = $cs;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

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
            $pokemon->addAttaque($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): static
    {
        if ($this->pokemons->removeElement($pokemon)) {
            $pokemons->removePokemon($this);
        }

        return $this;
    }
}
