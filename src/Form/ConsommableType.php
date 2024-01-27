<?php

namespace App\Form;

use App\Entity\Consommable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{Length, NotBlank};
use Symfony\Component\Form\Extension\Core\Type\{TextType, SubmitType};

class ConsommableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '10'
                ],
                'label' => 'ID',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un ID.'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 10,
                        'minMessage' => 'L\'id doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'id doit contenir au maximum {{ limit }} caractères.'
                    ])
                ]
            ])

            ->add('libelle', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '50'
                ],
                'label' => 'Libellé',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un libellé.'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'Le libellé doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le libellé doit contenir au maximum {{ limit }} caractères.'
                    ])
                ]
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
            'data_class' => Consommable::class,
        ]);
    }
}
