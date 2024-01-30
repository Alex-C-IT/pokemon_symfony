<?php

namespace App\Form;

use App\Entity\{Pokemon, Type, Generation, Attaque, Consommable, Stats};
use Symfony\Component\Form\Extension\Core\Type\{TextType, FileType, ChoiceType, IntegerType, SubmitType};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\{Length, NotBlank, File, Regex};
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /* Le formulaire est créé à partir de l'entité Attaque
        * Le champ 'numero' est un champ de type TextType. Il doit obligatoirement faire 4 caractères. Il est unique. Il est requis.
        * Le champ 'nom' est un champ de type TextType. Il doit faire entre 3 et 50 caractères. Il est requis. Il est unique.
        * Le champ 'image' est un champ de type FileType. Le fichier ne doit pas dépasser la taille de 150Ko. Il doit être au format .png. Il est requis.
        * Le champ 'miniImage' est un champ de type FileType. Le fichier ne doit pas dépasser la taille de 50Ko. Il doit être au format .png. Il est requis.
        * Le champ 'generation' est un champ de type EntityType. Il est requis. Il est lié à l'entité Generation. Il est affiché à partir de la propriété 'id'. Il est trié par ordre croissant sur la propriété 'numero'.
        * Le champ 'types' est un champ ChoiceType. Il est lié à l'entité Type. Il est requis. Il est affiché à partir de la propriété 'nom'. Il est trié par ordre croissant sur la propriété 'nom'. Il est multiple (max = 4). Il est étendu.
        * Le champ 'consommable' est un champ de type EntityType. Il est lié à l'entité Consommable. Il n'est pas requis. Il est affiché à partir de la propriété 'nom'. Il est trié par ordre croissant sur la propriété 'nom'.
        * Le champ 'attaques' est un champ ChoiceType. Il est lié à l'entité Attaque. Il est requis. Il est affiché à partir de la propriété 'nom'. Il est trié par ordre croissant sur la propriété 'nom'. Il affiche que les attaque du même type que le pokemon. Il est multiple. Il est étendu.
        * Le champ 'stats' est un champ de type StatsType. Il affiche le formulaire de StatsType. Il est requis.
        */
        $builder
            ->add('numero', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '4',
                    'maxlength' => '4'
                ],
                'label' => 'Numéro',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 4,
                        'max' => 4,
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '50'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (.png uniquement & 150 Ko max)',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/png'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '150k',
                        'mimeTypes' => [
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un fichier au format .png valide.',
                    ]),
                    new Length([
                        'max' => 150,
                        'maxMessage' => 'L\'image ne doit pas dépasser {{ limit }} Ko.'
                    ])
                ]
            ])
            ->add('miniImage', FileType::class, [
                'label' => 'Miniature (.png uniquement & 50 Ko max)',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/png'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '50k',
                        'mimeTypes' => [
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un fichier au format .png valide.',
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'L\'image ne doit pas dépasser {{ limit }} Ko.'
                    ])
                ]
            ])
            ->add('generation', EntityType::class, [
                'label' => 'Génération',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'class' => Generation::class,
                'choice_label' => 'id',
                'choice_attr' => [
                    'class' => 'form-select mt-2'
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('types', EntityType::class, [
                'label' => 'Types',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'class' => Type::class,
                'choice_label' => 'libelle',
                'choice_attr' => [
                    'class' => 'form-select mt-2'
                ],
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('consommable', EntityType::class, [
                'label' => 'Consommable',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'class' => Consommable::class,
                'choice_label' => 'libelle',
                'choice_attr' => [
                    'class' => 'form-select mt-2'
                ],
                'required' => false,
            ])
            ->add('attaques', EntityType::class, [
                'label' => 'Attaques',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'class' => Attaque::class,
                'choice_label' => 'nom',
                'choice_attr' => [
                    'class' => 'form-select mt-2'
                ],
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('stats', StatsType::class, [
                'label' => 'Statistiques',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
