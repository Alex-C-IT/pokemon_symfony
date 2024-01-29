<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TokenValidation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Enums\StatusEnum as Status;
use App\Repository\TokenValidationRepository;



class UserListener
{
    private UserPasswordHasherInterface $hasher;
    private TokenValidationRepository $repositoryTokenValidation;

    public function __construct(UserPasswordHasherInterface $hasher, TokenValidationRepository $repositoryTokenValidation)
    {
        $this->hasher = $hasher;
        $this->repositoryTokenValidation = $repositoryTokenValidation;
    }

    public function prePersist(User $user): void
    {

        $this->hashPassword($user);
    }

    public function postPersist(User $user): void
    {
        // Vérifie si l'utilisateur est en attente de validation
        if($user->getStatus() == Status::EN_ATTENTE_DE_VALIDATION) {
            // Créer un token de validation de compte
            $tokenValidation = new TokenValidation();
            $tokenValidation->setUserId($user->getId());
            // Générer un token
            $tokenValidation->setToken(bin2hex(random_bytes(32)));
            // Enregistrer le token en base de données
            $this->repositoryTokenValidation->add($tokenValidation);
            // Envoyer un email de confirmation d'inscription avec le token
            // sendMail($tokenValidation);
        }

    }

    private function sendMail(TokenValidation $tokenValidation): void 
    {
        return;
    }

    public function preUpdate(User $user): void
    {
        $this->hashPassword($user);
    }

    /**
     * Hash le mot de passe basé sur plainPassword avant l'insertion en base de données
     *
     * @param User $user
     * @return void
     */
    public function hashPassword(User $user): void
    {
        if($user->getPlainPassword() === null) {
            return;
        }
        $user->setPassword(
            $this->hasher->hashPassword(
                $user, 
                $user->getPlainPassword()
            )
        );
        $user->setPlainPassword(null);
    }
}