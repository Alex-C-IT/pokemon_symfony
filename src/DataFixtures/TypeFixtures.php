<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public const TYPE_REFERENCE = 'type';

    public function load(ObjectManager $manager): void
    {
        $types = [
            'Inconnu',
            'Feu',
            'Eau',
            'Plante',
            'Foudre',
            'Poison',
            'Psy',
            'Vol',
        ];

        foreach ($types as $key => $type) {
            // l'image se trouve dans public/images/types et est nommée de la façon suivante : nomtype.png en minuscule.
            $type = new Type($type);
            $type->setImage(strtolower($type->getLibelle()).'.png');
            $manager->persist($type);
            $this->addReference(self::TYPE_REFERENCE.'_'.$type->getLibelle(), $type);
        }

        $manager->flush();
    }
}
