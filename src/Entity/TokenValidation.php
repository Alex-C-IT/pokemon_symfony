<?php

namespace App\Entity;

use App\Repository\TokenValidationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenValidationRepository::class)]
class TokenValidation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $token = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateHeureCreation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateHeureExpiration = null;

    #[ORM\Column]
    private ?int $userId = null;

    public function __construct()
    {
        $this->dateHeureCreation = new \DateTimeImmutable();
        $this->dateHeureExpiration = (new \DateTimeImmutable())->modify('+30 days');
    }

    public function nombreDeJoursAvantExpirationToken(): int
    {
        $dateHeureExpiration = $this->getDateHeureExpiration();
        $dateHeureActuelle = new \DateTimeImmutable();
        $diff = $dateHeureExpiration->diff($dateHeureActuelle);

        return $diff->days;
    }

    public function dateAvantExpirationToken(): string
    {
        $dateHeureExpiration = $this->getDateHeureExpiration();

        return $dateHeureExpiration->format('d/m/Y');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getDateHeureCreation(): ?\DateTimeImmutable
    {
        return $this->dateHeureCreation;
    }

    public function setDateHeureCreation(\DateTimeImmutable $dateHeureCreation): static
    {
        $this->dateHeureCreation = $dateHeureCreation;

        return $this;
    }

    public function getDateHeureExpiration(): ?\DateTimeImmutable
    {
        return $this->dateHeureExpiration;
    }

    public function setDateHeureExpiration(\DateTimeImmutable $dateHeureExpiration): static
    {
        $this->dateHeureExpiration = $dateHeureExpiration;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
}
