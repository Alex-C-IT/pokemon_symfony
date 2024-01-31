<?php

namespace App\Form;

use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '25',
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
                        'min' => 3,
                        'max' => 25,
                        'minMessage' => 'Le libellé doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le libellé doit contenir au maximum {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (.png uniquement & 50 Ko max)',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/png',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '50k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un fichier au format .png valide.',
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'L\'image ne doit pas dépasser {{ limit }} Ko.',
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
            'data_class' => Type::class,
        ]);
    }
}
