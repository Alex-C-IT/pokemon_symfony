<?php

namespace App\DataFixtures;

use App\Entity\Pokemon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PokemonFixtures extends Fixture implements DependentFixtureInterface
{
    public const POKEMON_REFERENCE = 'pokemon'; // pokemon_nom

    public function getDependencies(): array
    {
        return [
            DresseurFixtures::class,
            TypeFixtures::class,
            AttaqueFixtures::class,
            GenerationFixtures::class,
            ConsommableFixtures::class,
            StatsFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // public function __construct(string $numero, string $nom, string $image, string $miniImage)
        // Les images de pokémons se trouvent dans public/images/pokemons et les images miniatures dans public/images/miniatures
        // Les images de pokémons sont nommées de la façon suivante : numero_nom.png
        // Les images miniatures de pokémons sont nommées de la façon suivante : numero_nom_mini.png

        // Pokémon de la première génération :
        // Bulbizarre
        $pokemon = new Pokemon('0001', 'Bulbizarre', '0001_Bulbizarre.png', '0001_Bulbizarre_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Plante'))->addType($this->getReference('type_Poison'));
        $pokemon->setStats($this->getReference('stats_1'));
        $pokemon->setConsommable($this->getReference('consommable_1'));
        $pokemon->addAttaque($this->getReference('attaque_5'))->addAttaque($this->getReference('attaque_6'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Herbizarre
        $pokemon = new Pokemon('0002', 'Herbizarre', '0002_Herbizarre.png', '0002_Herbizarre_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Plante'))->addType($this->getReference('type_Poison'));
        $pokemon->setStats($this->getReference('stats_2'));
        $pokemon->setConsommable($this->getReference('consommable_2'));
        $pokemon->addAttaque($this->getReference('attaque_5'))->addAttaque($this->getReference('attaque_6'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Florizarre
        $pokemon = new Pokemon('0003', 'Florizarre', '0003_Florizarre.png', '0003_Florizarre_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Plante'))->addType($this->getReference('type_Poison'));
        $pokemon->setStats($this->getReference('stats_3'));
        $pokemon->setConsommable($this->getReference('consommable_3'));
        $pokemon->addAttaque($this->getReference('attaque_5'))->addAttaque($this->getReference('attaque_6'));
        $pokemon->addDresseur($this->getReference('dresseur_Flora'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Salamèche
        $pokemon = new Pokemon('0004', 'Salamèche', '0004_Salameche.png', '0004_Salameche_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Feu'));
        $pokemon->setStats($this->getReference('stats_4'));
        $pokemon->setConsommable($this->getReference('consommable_4'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_4'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Reptincel
        $pokemon = new Pokemon('0005', 'Reptincel', '0005_Reptincel.png', '0005_Reptincel_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Feu'));
        $pokemon->setStats($this->getReference('stats_5'));
        $pokemon->setConsommable($this->getReference('consommable_5'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_4'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Dracaufeu
        $pokemon = new Pokemon('0006', 'Dracaufeu', '0006_Dracaufeu.png', '0006_Dracaufeu_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Feu'))->addType($this->getReference('type_Vol'));
        $pokemon->setStats($this->getReference('stats_6'));
        $pokemon->setConsommable($this->getReference('consommable_6'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_10'));
        $pokemon->addDresseur($this->getReference('dresseur_Sacha'))->addDresseur($this->getReference('dresseur_Flora'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Carapuce
        $pokemon = new Pokemon('0007', 'Carapuce', '0007_Carapuce.png', '0007_Carapuce_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Eau'));
        $pokemon->setStats($this->getReference('stats_7'));
        $pokemon->setConsommable($this->getReference('consommable_7'));
        $pokemon->addAttaque($this->getReference('attaque_1'))->addAttaque($this->getReference('attaque_2'));
        $pokemon->addDresseur($this->getReference('dresseur_Regis'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Carabaffe
        $pokemon = new Pokemon('0008', 'Carabaffe', '0008_Carabaffe.png', '0008_Carabaffe_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Eau'));
        $pokemon->setStats($this->getReference('stats_8'));
        $pokemon->setConsommable($this->getReference('consommable_8'));
        $pokemon->addAttaque($this->getReference('attaque_1'))->addAttaque($this->getReference('attaque_2'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Tortank
        $pokemon = new Pokemon('0009', 'Tortank', '0009_Tortank.png', '0009_Tortank_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Eau'));
        $pokemon->setStats($this->getReference('stats_9'));
        $pokemon->setConsommable($this->getReference('consommable_9'));
        $pokemon->addAttaque($this->getReference('attaque_1'))->addAttaque($this->getReference('attaque_2'));
        $pokemon->addDresseur($this->getReference('dresseur_Regis'))->addDresseur($this->getReference('dresseur_Flora'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Pikachu
        $pokemon = new Pokemon('0025', 'Pikachu', '0025_Pikachu.png', '0025_Pikachu_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Foudre'));
        $pokemon->setStats($this->getReference('stats_10'));
        $pokemon->setConsommable($this->getReference('consommable_10'));
        $pokemon->addAttaque($this->getReference('attaque_7'))->addAttaque($this->getReference('attaque_8'));
        $pokemon->addDresseur($this->getReference('dresseur_Sacha'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Raichu
        $pokemon = new Pokemon('0026', 'Raichu', '0026_Raichu.png', '0026_Raichu_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Foudre'));
        $pokemon->setStats($this->getReference('stats_11'));
        $pokemon->setConsommable($this->getReference('consommable_11'));
        $pokemon->addAttaque($this->getReference('attaque_7'))->addAttaque($this->getReference('attaque_8'));
        $pokemon->addDresseur($this->getReference('dresseur_Regis'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Pokémon de la deuxième génération :
        // Lugia
        $pokemon = new Pokemon('0249', 'Lugia', '0249_Lugia.png', '0249_Lugia_mini.png');
        $pokemon->setGeneration($this->getReference('generation_2'));
        $pokemon->addType($this->getReference('type_Psy'))->addType($this->getReference('type_Vol'));
        $pokemon->setStats($this->getReference('stats_12'));
        $pokemon->setConsommable($this->getReference('consommable_12'));
        $pokemon->addAttaque($this->getReference('attaque_10'))->addAttaque($this->getReference('attaque_12'));
        $pokemon->addDresseur($this->getReference('dresseur_Sacha'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Ho-Oh
        $pokemon = new Pokemon('0250', 'Ho-Oh', '0250_Ho-Oh.png', '0250_Ho-Oh_mini.png');
        $pokemon->setGeneration($this->getReference('generation_2'));
        $pokemon->addType($this->getReference('type_Feu'))->addType($this->getReference('type_Vol'));
        $pokemon->setStats($this->getReference('stats_13'));
        $pokemon->setConsommable($this->getReference('consommable_13'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_10'));
        $pokemon->addDresseur($this->getReference('dresseur_Flora'));
        $this->addReference(self::POKEMON_REFERENCE.'_'.$pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        $manager->flush();
    }
}
