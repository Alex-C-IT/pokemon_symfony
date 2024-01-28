<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Enums\Status;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function load(ObjectManager $manager): void
    {
        // Un utilisateur d'un idUtilisateur, d'un nomUtilisateur, d'un password et d'un email
        // public function _construct(int $idUtilisateur, string $nomUtilisateur, string $password, string $email)
        $user = new User("admin", "admin", "admin@pokemon.fr");
        $user->setStatus(Status::ADMINISTRATEUR);
        $this->addReference(self::USER_REFERENCE . '_' . '1', $user);
        $manager->persist($user);


        $user = new User("user", "user", "user@pokemo.fr");
        $manager->persist($user);
        $this->addReference(self::USER_REFERENCE . '_' . '2', $user);
        $manager->persist($user);

        $user = new User("user2", "user2", "user2@pokemon.fr");
        $user->setStatus(Status::BANNI);
        $this->addReference(self::USER_REFERENCE . '_' . '3', $user);
        $manager->persist($user);

        $manager->flush();
    }
}
