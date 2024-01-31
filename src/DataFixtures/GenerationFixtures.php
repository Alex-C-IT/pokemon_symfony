<?php

namespace App\DataFixtures;

use App\Entity\Generation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenerationFixtures extends Fixture
{
    public const GENERATION_REFERENCE = 'generation';

    public function load(ObjectManager $manager): void
    {
        // Une génération est composée d'un numéro (string) (1 pour première génération, 2 pour deuxième génération, etc.) et de son année (string).
        $generation = new Generation('1', '1996');
        $manager->persist($generation);
        $this->addReference(self::GENERATION_REFERENCE.'_1', $generation);

        $generation2 = new Generation('2', '2000');
        $manager->persist($generation2);
        $this->addReference(self::GENERATION_REFERENCE.'_2', $generation2);

        $manager->flush();
    }
}
