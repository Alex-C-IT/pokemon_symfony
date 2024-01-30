<?php

namespace App\Form;

use App\Entity\Generation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GenerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '10',
                ],
                'label' => 'ID',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un ID.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 10,
                        'minMessage' => 'L\'id doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'id doit contenir au maximum {{ limit }} caractères.',
                    ]),
                ],
            ])

            ->add('numero', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '1',
                    'maxlength' => '2',
                ],
                'label' => 'Numéro',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un numéro (ex : 3 pour la 3ème génération).',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 2,
                        'minMessage' => 'Le numéro doit être composé d\'au moins {{ limit }} chiffre.',
                        'maxMessage' => 'Le numéro doit contenir au maximum {{ limit }} chiffres.',
                    ]),
                ],
            ])
            ->add('annee', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '4',
                    'maxlength' => '4',
                ],
                'label' => 'Année',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir l\'année de la génération.',
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 4,
                        'minMessage' => 'Une année est composée de {{ limit }} chiffres.',
                        'maxMessage' => 'Une année est composée de {{ limit }} chiffres.',
                    ]),
                ],
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
            'data_class' => Generation::class,
        ]);
    }
}
