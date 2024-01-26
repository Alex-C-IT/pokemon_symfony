<?php

namespace App\Entity;

use App\Repository\AttaqueRepository;
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
    private ?int $precisionn = null;

    #[ORM\Column]
    private ?int $pp = null;

    #[ORM\Column]
    private ?bool $cs = null;

    // N'est pas unique. Un type peut être utilisé par plusieurs attaques
    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'attaques')]
    private ?Type $type = null;

    public function __construct(string $id, string $nom, string $description, int $puissance, int $precisionn, int $pp, bool $cs, Type $type)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->puissance = $puissance;
        $this->precisionn = $precisionn;
        $this->pp = $pp;
        $this->cs = $cs;
        $this->type = $type;
    }
    
    public function getId(): ?string
    {
        return $this->id;
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

    public function getPrecisionn(): ?int
    {
        return $this->precisionn;
    }

    public function setPrecisionn(int $precisionn): static
    {
        $this->precisionn = $precisionn;

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
}
