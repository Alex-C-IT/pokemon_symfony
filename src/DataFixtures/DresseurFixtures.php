<?php

namespace App\DataFixtures;

use App\Entity\Dresseur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DresseurFixtures extends Fixture implements DependentFixtureInterface
{
    public const DRESSEUR_REFERENCE = 'dresseur';

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // public function __construct(string $nom, int $taille, bool $sexe, ?string $message)
        // Sacha - 170cm - Homme = 0 - Je veux devenir le meilleur dresseur !
        $dresseur = new Dresseur('Sacha', 170, false, 'Je veux devenir le meilleur dresseur !');
        $dresseur->setUser($this->getReference('user_1'));
        // $dresseur->addPokemon($this->getReference('pokemon_Pikachu'))->addPokemon($this->getReference('pokemon_Dracaufeu'))->addPokemon($this->getReference('pokemon_Lugia'));
        $this->addReference(self::DRESSEUR_REFERENCE.'_'.$dresseur->getNom(), $dresseur);
        $manager->persist($dresseur);

        // Regis - 180cm - Homme = 0 - Sacha, mon rival éternel !
        $dresseur = new Dresseur('Regis', 180, false, 'Sacha, mon rival éternel !');
        $dresseur->setUser($this->getReference('user_2'));
        // $dresseur->addPokemon($this->getReference('pokemon_Carapuce'))->addPokemon($this->getReference('pokemon_Tortank'))->addPokemon($this->getReference('pokemon_Raichu'));
        $this->addReference(self::DRESSEUR_REFERENCE.'_'.$dresseur->getNom(), $dresseur);
        $manager->persist($dresseur);

        // Flora - 160cm - Femme = 1 - Je suis la championne !
        $dresseur = new Dresseur('Flora', 160, true, 'Je suis la championne !');
        $dresseur->setUser($this->getReference('user_3'));
        // $dresseur->addPokemon($this->getReference('pokemon_Florizarre'))->addPokemon($this->getReference('pokemon_Tortank'))->addPokemon($this->getReference('pokemon_Dracaufeu'))->addPokemon($this->getReference('pokemon_Ho-Oh'));
        $this->addReference(self::DRESSEUR_REFERENCE.'_'.$dresseur->getNom(), $dresseur);
        $manager->persist($dresseur);

        $manager->flush();
    }
}
