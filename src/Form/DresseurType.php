<?php

namespace App\Form;

use App\Entity\Dresseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\{Pokemon, User};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\{TextType, IntegerType, CheckboxType, SubmitType};
use Symfony\Component\Validator\Constraints\{NotBlank, Length};


class DresseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '25'
                ],
                'label' => 'Nom du dresseur',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
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
                    'max' => '250'
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
                    'style' => 'font-weight: bold'
                ],
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'required' => false
            ])
            ->add('message', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '0',
                    'maxlength' => '120'
                ],
                'label' => 'Message',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new Length([
                        'min' => 0,
                        'max' => 120,
                    ]),
                ],
            ])
            ->add('user', EntityType::class, [
                'label' => 'Utilisateur associé',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'class' => User::class,
                'choice_label' => 'nomUtilisateur',
                'choice_attr' => [
                    'class' => 'form-select mt-2'
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('pokemons', EntityType::class, [
                'label' => 'Pokémons associés',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'class' => Pokemon::class,
                'choice_label' => 'nom',
                'choice_attr' => [
                    'class' => 'form-select mt-2'
                ],
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'by_reference' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-4'
                ],
                'label' => 'Valider'
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
