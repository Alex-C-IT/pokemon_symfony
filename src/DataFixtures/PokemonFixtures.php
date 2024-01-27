<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pokemon;


class PokemonFixtures extends Fixture implements DependentFixtureInterface
{
    public const POKEMON_REFERENCE = 'pokemon'; //pokemon_nom

    public function getDependencies(): array
    {
        return [
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
        $pokemon = new Pokemon('0001', 'Bulbizarre', '001_Bulbizarre.png', '001_Bulbizarre_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Plante'))->addType($this->getReference('type_Poison'));
        $pokemon->setStats($this->getReference('stats_1'));
        $pokemon->setConsommable($this->getReference('consommable_1'));
        $pokemon->addAttaque($this->getReference('attaque_5'))->addAttaque($this->getReference('attaque_6'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Herbizarre
        $pokemon = new Pokemon('0002', 'Herbizarre', '002_Herbizarre.png', '002_Herbizarre_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Plante'))->addType($this->getReference('type_Poison'));
        $pokemon->setStats($this->getReference('stats_2'));
        $pokemon->setConsommable($this->getReference('consommable_2'));
        $pokemon->addAttaque($this->getReference('attaque_5'))->addAttaque($this->getReference('attaque_6'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Florizarre
        $pokemon = new Pokemon('0003', 'Florizarre', '003_Florizarre.png', '003_Florizarre_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Plante'))->addType($this->getReference('type_Poison'));
        $pokemon->setStats($this->getReference('stats_3'));
        $pokemon->setConsommable($this->getReference('consommable_3'));
        $pokemon->addAttaque($this->getReference('attaque_5'))->addAttaque($this->getReference('attaque_6'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Salamèche
        $pokemon = new Pokemon('0004', 'Salamèche', '004_Salameche.png', '004_Salameche_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Feu'));
        $pokemon->setStats($this->getReference('stats_4'));
        $pokemon->setConsommable($this->getReference('consommable_4'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_4'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Reptincel
        $pokemon = new Pokemon('0005', 'Reptincel', '005_Reptincel.png', '005_Reptincel_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Feu'));
        $pokemon->setStats($this->getReference('stats_5'));
        $pokemon->setConsommable($this->getReference('consommable_5'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_4'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Dracaufeu
        $pokemon = new Pokemon('0006', 'Dracaufeu', '006_Dracaufeu.png', '006_Dracaufeu_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Feu'))->addType($this->getReference('type_Vol'));
        $pokemon->setStats($this->getReference('stats_6'));
        $pokemon->setConsommable($this->getReference('consommable_6'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_10'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Carapuce
        $pokemon = new Pokemon('0007', 'Carapuce', '007_Carapuce.png', '007_Carapuce_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Eau'));
        $pokemon->setStats($this->getReference('stats_7'));
        $pokemon->setConsommable($this->getReference('consommable_7'));
        $pokemon->addAttaque($this->getReference('attaque_1'))->addAttaque($this->getReference('attaque_2'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Carabaffe
        $pokemon = new Pokemon('0008', 'Carabaffe', '008_Carabaffe.png', '008_Carabaffe_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Eau'));
        $pokemon->setStats($this->getReference('stats_8'));
        $pokemon->setConsommable($this->getReference('consommable_8'));
        $pokemon->addAttaque($this->getReference('attaque_1'))->addAttaque($this->getReference('attaque_2'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Tortank
        $pokemon = new Pokemon('0009', 'Tortank', '009_Tortank.png', '009_Tortank_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Eau'));
        $pokemon->setStats($this->getReference('stats_9'));
        $pokemon->setConsommable($this->getReference('consommable_9'));
        $pokemon->addAttaque($this->getReference('attaque_1'))->addAttaque($this->getReference('attaque_2'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Pikachu
        $pokemon = new Pokemon('0025', 'Pikachu', '025_Pikachu.png', '025_Pikachu_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Foudre'));
        $pokemon->setStats($this->getReference('stats_10'));
        $pokemon->setConsommable($this->getReference('consommable_10'));
        $pokemon->addAttaque($this->getReference('attaque_7'))->addAttaque($this->getReference('attaque_8'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Raichu
        $pokemon = new Pokemon('0026', 'Raichu', '026_Raichu.png', '026_Raichu_mini.png');
        $pokemon->setGeneration($this->getReference('generation_1'));
        $pokemon->addType($this->getReference('type_Foudre'));
        $pokemon->setStats($this->getReference('stats_11'));
        $pokemon->setConsommable($this->getReference('consommable_11'));
        $pokemon->addAttaque($this->getReference('attaque_7'))->addAttaque($this->getReference('attaque_8'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Pokémon de la deuxième génération :
        // Lugia
        $pokemon = new Pokemon('0249', 'Lugia', '249_Lugia.png', '249_Lugia_mini.png');
        $pokemon->setGeneration($this->getReference('generation_2'));
        $pokemon->addType($this->getReference('type_Psy'))->addType($this->getReference('type_Vol'));
        $pokemon->setStats($this->getReference('stats_12'));
        $pokemon->setConsommable($this->getReference('consommable_12'));
        $pokemon->addAttaque($this->getReference('attaque_10'))->addAttaque($this->getReference('attaque_12'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        // Ho-Oh
        $pokemon = new Pokemon('0250', 'Ho-Oh', '250_Ho-Oh.png', '250_Ho-Oh_mini.png');
        $pokemon->setGeneration($this->getReference('generation_2'));
        $pokemon->addType($this->getReference('type_Feu'))->addType($this->getReference('type_Vol'));
        $pokemon->setStats($this->getReference('stats_13'));
        $pokemon->setConsommable($this->getReference('consommable_13'));
        $pokemon->addAttaque($this->getReference('attaque_3'))->addAttaque($this->getReference('attaque_10'));
        $this->addReference(self::POKEMON_REFERENCE . '_' . $pokemon->getNom(), $pokemon);
        $manager->persist($pokemon);

        $manager->flush();
    }
}
