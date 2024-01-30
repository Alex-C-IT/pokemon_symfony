<?php

namespace App\Form;

use App\Entity\Stats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class StatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pv', IntegerType::class, [
            'label' => 'PV',
            'attr' => [
                'class' => 'form-control',
                'min' => '1',
                'max' => '999',
            ],
            'label_attr' => [
                'class' => 'form-label mt-2',
                'style' => 'font-weight: bold',
            ],
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 1,
                    'max' => 999,
                ]),
            ],
        ])
        ->add('attaque', IntegerType::class, [
            'label' => 'Attaque',
            'attr' => [
                'class' => 'form-control',
                'min' => '1',
                'max' => '999',
            ],
            'label_attr' => [
                'class' => 'form-label mt-2',
                'style' => 'font-weight: bold',
            ],
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 1,
                    'max' => 999,
                ]),
            ],
        ])
        ->add('defense', IntegerType::class, [
            'label' => 'Défense',
            'attr' => [
                'class' => 'form-control',
                'min' => '1',
                'max' => '999',
            ],
            'label_attr' => [
                'class' => 'form-label mt-2',
                'style' => 'font-weight: bold',
            ],
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 1,
                    'max' => 999,
                ]),
            ],
        ])
        ->add('vitesse', IntegerType::class, [
            'label' => 'Vitesse',
            'attr' => [
                'class' => 'form-control',
                'min' => '1',
                'max' => '999',
            ],
            'label_attr' => [
                'class' => 'form-label mt-2',
                'style' => 'font-weight: bold',
            ],
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 1,
                    'max' => 999,
                ]),
            ],
        ])
        ->add('special', IntegerType::class, [
            'label' => 'Spécial',
            'attr' => [
                'class' => 'form-control',
                'min' => '1',
                'max' => '999',
            ],
            'label_attr' => [
                'class' => 'form-label mt-2',
                'style' => 'font-weight: bold',
            ],
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 1,
                    'max' => 999,
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stats::class,
        ]);
    }
}
