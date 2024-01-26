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
            $type = new Type('TYPE' . $key + 1, $type);
            /*if($type->getLibelle() == 'Feu') {
                $type->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Salameche'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Reptincel'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Dracaufeu'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Ho-Oh'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '3'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '4'));
            }
            else if($type->getLibelle() == 'Eau') {
                $type->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Carapuce'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Carabaffe'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Tortank'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '1'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '2'));
            }
            else if($type->getLibelle() == 'Plante') {
                $type->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Bulbizarre'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Herbizarre'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Florizarre'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '5'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '6'));
            }
            else if($type->getLibelle() == 'Foudre') {
                $type->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Pikachu'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Raichu'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '7'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '8'));

            }
            else if($type->getLibelle() == 'Poison') {
                $type->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Bulbizarre'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Herbizarre'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Florizarre'));
            }
            else if($type->getLibelle() == 'Psy') {
                $type->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Lugia'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '11'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '12'));
            }
            else if($type->getLibelle() == 'Vol') {
                $type->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Lugia'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Ho-Oh'))
                    ->addPokemon($this->getReference(PokemonFixtures::POKEMON_REFERENCE . '_' . 'Dracaufeu'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '9'))
                    ->addAttaque($this->getReference(AttaqueFixtures::ATTAQUE_REFERENCE . '_' . '10'));
            }*/

            $manager->persist($type);
            $this->addReference(self::TYPE_REFERENCE . '_' . $type->getLibelle(), $type);
        }

        $manager->flush();
    }
}
