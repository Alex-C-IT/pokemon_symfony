<?php

namespace App\DataFixtures;

use App\Entity\Consommable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConsommableFixtures extends Fixture
{
    public const CONSOMMABLE_REFERENCE = 'consommable';

    public function load(ObjectManager $manager): void
    {
        $consommables = [
            'Pierre Feu',
            'Pierre Eau',
            'Pierre Foudre',
            'Pierre Plante',
            'Baie Oran',
            'Baie Sitrus',
            'Baie Maron',
            'Baie Ceriz',
            'Baie Fraive',
            'Baie Pêcha',
            'Baie Willia',
            'Baie Mepo',
            'Baie Nanone',
        ];

        foreach ($consommables as $key => $consommable) {
            $consommable = new Consommable($consommable);
            $manager->persist($consommable);
            $this->addReference(self::CONSOMMABLE_REFERENCE.'_'.$key + 1, $consommable);
        }

        $manager->flush();
    }
}
