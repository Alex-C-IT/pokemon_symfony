<?php

namespace App\Form;

use App\Entity\Dresseur;
use App\Entity\Pokemon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MesDresseursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '25',
                ],
                'label' => 'Nom du dresseur',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        'max' => 25,
                    ]),
                ],
            ])
            ->add('taille', IntegerType::class, [
                'label' => 'Taille (cm)',
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '250',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 250,
                    ]),
                ],
            ])
            ->add('sexe', CheckboxType::class, [
                'label' => 'Est-ce une fille ?',
                'label_attr' => [
                    'class' => 'form-check-label ml-2',
                    'style' => 'font-weight: bold',
                ],
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
            ])
            ->add('message', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '0',
                    'maxlength' => '120',
                ],
                'label' => 'Message',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new Length([
                        'min' => 0,
                        'max' => 120,
                    ]),
                ],
            ])
            ->add('pokemons', EntityType::class, [
                'label' => 'Ses pokémons',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold',
                ],
                'class' => Pokemon::class,
                'choice_label' => 'nom',
                'choice_attr' => [
                    'class' => 'form-select mt-2',
                ],
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'by_reference' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-4',
                ],
                'label' => 'Valider',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dresseur::class,
        ]);
    }
}
