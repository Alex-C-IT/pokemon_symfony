<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatsRepository::class)]
class Stats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pv = null;

    #[ORM\Column]
    private ?int $attaque = null;

    #[ORM\Column]
    private ?int $defense = null;

    #[ORM\Column]
    private ?int $vitesse = null;

    #[ORM\Column]
    private ?int $special = null;

    public function __construct(int $pv = null, int $attaque = null, int $defense = null, int $vitesse = null, int $special = null)
    {
        $this->pv = $pv;
        $this->attaque = $attaque;
        $this->defense = $defense;
        $this->vitesse = $vitesse;
        $this->special = $special;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(int $pv): static
    {
        $this->pv = $pv;

        return $this;
    }

    public function getAttaque(): ?int
    {
        return $this->attaque;
    }

    public function setAttaque(int $attaque): static
    {
        $this->attaque = $attaque;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): static
    {
        $this->defense = $defense;

        return $this;
    }

    public function getVitesse(): ?int
    {
        return $this->vitesse;
    }

    public function setVitesse(int $vitesse): static
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getSpecial(): ?int
    {
        return $this->special;
    }

    public function setSpecial(int $special): static
    {
        $this->special = $special;

        return $this;
    }
}
