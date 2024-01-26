<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stats;

class StatsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // public function __construct(int $pv, int $attaque, int $defense, int $vitesse, int $special)
        // Stats pour le pokémon Bulbizarre
        $stats = new Stats(45, 49, 49, 45, 65);
        $manager->persist($stats);
        $this->addReference('stats_1', $stats);
        // Stats pour le pokémon Herbizarre
        $stats = new Stats(60, 62, 63, 60, 80);
        $manager->persist($stats);
        $this->addReference('stats_2', $stats);
        // Stats pour le pokémon Florizarre
        $stats = new Stats(80, 82, 83, 80, 100);
        $manager->persist($stats);
        $this->addReference('stats_3', $stats);
        // Stats pour le pokémon Salamèche
        $stats = new Stats(39, 52, 43, 65, 50);
        $manager->persist($stats);
        $this->addReference('stats_4', $stats);
        // Stats pour le pokémon Reptincel
        $stats = new Stats(58, 64, 58, 80, 65);
        $manager->persist($stats);
        $this->addReference('stats_5', $stats);
        // Stats pour le pokémon Dracaufeu
        $stats = new Stats(78, 84, 78, 100, 85);
        $manager->persist($stats);
        $this->addReference('stats_6', $stats);
        // Stats pour le pokémon Carapuce
        $stats = new Stats(44, 48, 65, 43, 50);
        $manager->persist($stats);
        $this->addReference('stats_7', $stats);
        // Stats pour le pokémon Carabaffe
        $stats = new Stats(59, 63, 80, 58, 65);
        $manager->persist($stats);
        $this->addReference('stats_8', $stats);
        // Stats pour le pokémon Tortank
        $stats = new Stats(79, 83, 100, 78, 85);
        $manager->persist($stats);
        $this->addReference('stats_9', $stats);
        // Stats pour le pokémon Pikachu
        $stats = new Stats(35, 55, 40, 90, 50);
        $manager->persist($stats);
        $this->addReference('stats_10', $stats);
        // Stats pour le pokémon Raichu
        $stats = new Stats(60, 90, 55, 100, 90);
        $manager->persist($stats);
        $this->addReference('stats_11', $stats);
        // Stats pour le pokémon Lugia
        $stats = new Stats(106, 90, 130, 110, 154);
        $manager->persist($stats);
        $this->addReference('stats_12', $stats);
        // Stats pour le pokémon Ho-Oh
        $stats = new Stats(106, 130, 90, 110, 154);
        $manager->persist($stats);
        $this->addReference('stats_13', $stats);

        $manager->flush();
    }
}
