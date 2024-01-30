<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enums\StatusEnum as Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setNomUtilisateur('admin');
        $user->setPlainPassword('admin');
        $user->setEmail('admin@pokemonsymfony.fr');
        $user->setStatus(Status::ACTIF);
        $user->setIsSubscribedNewsletter(true);
        $user->addRole('ROLE_ADMIN');
        $this->addReference(self::USER_REFERENCE.'_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setNomUtilisateur('user');
        $user->setPlainPassword('user');
        $user->setEmail('user@pokemonsymfony.fr');
        $user->setIsSubscribedNewsletter(false);
        $this->addReference(self::USER_REFERENCE.'_2', $user);
        $manager->persist($user);

        $user = new User();
        $user->setNomUtilisateur('user2');
        $user->setPlainPassword('user2');
        $user->setEmail('user2@pokemonsymfony.fr');
        $user->setStatus(Status::BANNI);
        $user->setIsSubscribedNewsletter(false);
        $this->addReference(self::USER_REFERENCE.'_3', $user);
        $manager->persist($user);

        $manager->flush();
    }
}
