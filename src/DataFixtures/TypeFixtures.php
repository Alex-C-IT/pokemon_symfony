<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Type;

class TypeFixtures extends Fixture
{
    public const TYPE_REFERENCE = 'type';

    /*public function getDependencies(): array
    {
        return [
            PokemonFixtures::class,
        ];
    }*/

    public function load(ObjectManager $manager): void
    {
        $types = [
            'Feu',
            'Eau',
            'Plante',
            'Foudre',
            'Poison',
            'Psy',
            'Vol'
        ];

        foreach ($types as $key => $type) {
            // l'image se trouve dans public/images/types et est nommée de la façon suivante : nomtype.png en minuscule.
            $type = new Type('TYPE' . $key + 1, $type);
            $type->setImage(strtolower($type->getLibelle()) . '.png');
            $manager->persist($type);
            $this->addReference(self::TYPE_REFERENCE . '_' . $type->getLibelle(), $type);
        }

        $manager->flush();
    }
}
