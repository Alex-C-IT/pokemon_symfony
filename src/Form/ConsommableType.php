<?php

namespace App\Form;

use App\Entity\Consommable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConsommableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '50',
                ],
                'label' => 'Libellé',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un libellé.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'Le libellé doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le libellé doit contenir au maximum {{ limit }} caractères.',
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
            'data_class' => Consommable::class,
        ]);
    }
}
