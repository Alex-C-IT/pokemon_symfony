<?php

namespace App\Form;

use App\Entity\Attaque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{Length, NotBlank};
use Symfony\Component\Form\Extension\Core\Type\{TextType, IntegerType, SubmitType, CheckboxType};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Type;


class AttaqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /* Le formulaire est créé à partir de l'entité Attaque
        *  Le champ ID, de type string, est obligatoire. Il doit faire au minimum 4 caractères et au maximum 10 caractères.
        *  Le champ nom, de type string, est obligatoire. Il doit faire au minimum 3 caractères et au maximum 50 caractères.
        *  Le champ type, de type Type, est obligatoire et doit être une liste déroulante avec les types existants.
        *  Le champ description, de type string, est obligatoire. Il doit faire au minimum 10 caractères et au maximum 255 caractères.
        *  Le champ puissance, de type integer, est obligatoire. Il doit être compris entre 0 et 400.
        *  Le champ précision, de type integer, est obligatoire. Il doit être compris entre 0 et 100.
        *  Le champ PP, de type integer, est obligatoire. Il doit être compris entre 0 et 50.
        *  Le champ CS, de type checkbox, est obligatoire.
        */
        $builder 
            ->add('id', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '4',
                    'maxlength' => '10'
                ],
                'label' => 'ID',
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 4,
                        'max' => 10,
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
            ->add('type', EntityType::class, [
                'label' => 'Type',
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
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '10',
                    'maxlength' => '255'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10,
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('puissance', IntegerType::class, [
                'label' => 'Puissance',
                'attr' => [
                    'class' => 'form-control',
                    'min' => '0',
                    'max' => '400'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 0,
                        'max' => 400,
                    ]),
                ],
            ])
            ->add('prec', IntegerType::class, [
                'label' => 'Précision',
                'attr' => [
                    'class' => 'form-control',
                    'min' => '0',
                    'max' => '100'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 0,
                        'max' => 100,
                    ]),
                ],
            ])
            ->add('pp', IntegerType::class, [
                'label' => 'PP',
                'attr' => [
                    'class' => 'form-control',
                    'min' => '0',
                    'max' => '50'
                ],
                'label_attr' => [
                    'class' => 'form-label mt-2',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 0,
                        'max' => 50,
                    ]),
                ],
            ])
            ->add('cs', CheckboxType::class, [
                'label' => 'Capacité spéciale ?',
                'label_attr' => [
                    'class' => 'form-check-label ml-2',
                    'style' => 'font-weight: bold'
                ],
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'required' => false
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
            'data_class' => Attaque::class,
        ]);
    }
}