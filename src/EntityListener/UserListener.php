<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user): void
    {
        $this->hashPassword($user);
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