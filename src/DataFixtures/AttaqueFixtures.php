<?php

namespace App\DataFixtures;

use App\Entity\Attaque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AttaqueFixtures extends Fixture implements DependentFixtureInterface
{
    public const ATTAQUE_REFERENCE = 'attaque';

    public function getDependencies(): array
    {
        return [
            TypeFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // 2 attaques de type Eau
        // Attaque 1 - Nom : Pistolet à O, Description : Attaque de base, Puissance : 40, Précision : 100, PP : 35, CS : false, Type : Eau
        $attaque = new Attaque('Pistolet à O', 'De l\'eau est projetée avec force sur la cible.', 40, 100, 35, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Eau'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_1', $attaque);

        // Attaque 2 - Hydrocanon : Nom : Hydrocanon, Description : Un puissant jet d’eau est dirigé sur la cible., Puissance : 110, Précision : 80, PP : 5, CS : false, Type : Eau
        $attaque = new Attaque('Hydrocanon', 'Un puissant jet d\'eau est dirigé sur la cible.', 110, 80, 5, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Eau'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_2', $attaque);

        // 2 attaques de type Feu
        // Attaque 3 - Lance-Flammes : Nom : Lance-Flammes, Description : Un jet de feu brûlant est projeté sur la cible., Puissance : 90, Précision : 100, PP : 15, CS : false, Type : Feu
        $attaque = new Attaque('Lance-Flammes', 'Un jet de feu brûlant est projeté sur la cible.', 90, 100, 15, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Feu'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_3', $attaque);

        // Attaque 4 - Déflagration : Nom : Déflagration, Description : Un puissant jet de feu qui peut brûler la cible., Puissance : 110, Précision : 85, PP : 5, CS : false, Type : Feu
        $attaque = new Attaque('Déflagration', 'Un puissant jet de feu qui peut brûler la cible.', 110, 85, 5, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Feu'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_4', $attaque);

        // 2 attaques de type Plante
        // Attaque 5 - Tranch’Herbe : Nom : Tranch’Herbe, Description : Lames d’air tranchantes comme des lames de rasoir., Puissance : 55, Précision : 95, PP : 25, CS : false, Type : Plante
        $attaque = new Attaque('Tranch\'Herbe', 'Lames d\'air tranchantes comme des lames de rasoir.', 55, 95, 25, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Plante'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_5', $attaque);

        // Attaque 6 - Tempête Verte : Nom : Tempête Verte, Description : Une tempête de feuilles taillantes balaie la cible., Puissance : 90, Précision : 100, PP : 15, CS : false, Type : Plante
        $attaque = new Attaque('Tempête Verte', 'Une tempête de feuilles taillantes balaie la cible.', 90, 100, 15, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Plante'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_6', $attaque);

        // 2 attaques de type Foudre
        // Attaque 7 - Tonnerre : Nom : Tonnerre, Description : Une violente décharge électrique s’abat sur la cible., Puissance : 90, Précision : 100, PP : 15, CS : false, Type : Foudre
        $attaque = new Attaque('Tonnerre', 'Une violente décharge électrique s\'abat sur la cible.', 90, 100, 15, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Foudre'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_7', $attaque);

        // Attaque 8 - Fatal-Foudre : Nom : Fatal-Foudre, Description : Une violente décharge électrique s’abat sur la cible. Peut paralyser la cible., Puissance : 110, Précision : 70, PP : 10, CS : false, Type : Foudre
        $attaque = new Attaque('Fatal-Foudre', 'Une violente décharge électrique s\'abat sur la cible. Peut paralyser la cible.', 110, 70, 10, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Foudre'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_8', $attaque);

        // 2 attaques de type Vol
        // Attaque 9 - Rapace : Nom : Rapace, Description : Une charge brutale qui blesse aussi l’utilisateur., Puissance : 120, Précision : 100, PP : 15, CS : false, Type : Vol
        $attaque = new Attaque('Rapace', 'Une charge brutale qui blesse aussi l\'utilisateur.', 120, 100, 15, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Vol'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_9', $attaque);

        // Attaque 10 - Vent Violent : Nom : Vent Violent, Description : Une bourrasque violente qui s’abat sur la cible., Puissance : 110, Précision : 70, PP : 10, CS : false, Type : Vol
        $attaque = new Attaque('Vent Violent', 'Une bourrasque violente qui s\'abat sur la cible.', 110, 70, 10, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Vol'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_10', $attaque);

        // 2 attaques de type Psy
        // Attaque 11 - Choc Mental : Nom : Choc Mental, Description : Une puissante attaque psychique qui peut aussi baisser la Défense Spéciale de la cible., Puissance : 50, Précision : 100, PP : 25, CS : false, Type : Psy
        $attaque = new Attaque('Choc Mental', 'Une puissante attaque psychique qui peut aussi baisser la Défense Spéciale de la cible.', 50, 100, 25, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Psy'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_11', $attaque);

        // Attaque 12 - Psyko : Nom : Psyko, Description : Une puissante attaque psychique qui peut aussi baisser la Défense Spéciale de la cible., Puissance : 90, Précision : 100, PP : 10, CS : false, Type : Psy
        $attaque = new Attaque('Psyko', 'Une puissante attaque psychique qui peut aussi baisser la Défense Spéciale de la cible.', 90, 100, 10, false, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Psy'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_12', $attaque);

        // Attaque 13 - Surf : Nom : Surf, Description : Une vague déferlante s’abat sur tout ce qui entoure l’utilisateur. Peut aussi être utilisée pour traverser l’eau., Puissance : 90, Précision : 100, PP : 15, CS : true, Type : Eau
        $attaque = new Attaque('Surf', 'Une vague déferlante s\'abat sur tout ce qui entoure l\'utilisateur. Peut aussi être utilisée pour traverser l\'eau.', 90, 100, 15, true, $this->getReference(TypeFixtures::TYPE_REFERENCE.'_Eau'));
        $manager->persist($attaque);
        $this->addReference(self::ATTAQUE_REFERENCE.'_13', $attaque);

        $manager->flush();
    }
}
