<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{Length, NotBlank, Email, NotNull, IsTrue, IsFalse, IsNull, IsNullValidator, IsTrueValidator, IsFalseValidator, NotNullValidator, NotBlankValidator, EmailValidator, LengthValidator, NotCompromisedPassword};
use Symfony\Component\Form\Extension\Core\Type\{TextType, PasswordType, SubmitType, EmailType, CheckboxType, RepeatedType};


class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUtilisateur', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '25'
                ],
                'label' => 'Nom d\'utilisateur',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom d\'utilisateur.'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 25,
                        'minMessage' => 'Le nom d\'utilisateur doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom d\'utilisateur doit contenir au maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '8',
                        'maxlength' => '255'
                    ]
                ],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                        'style' => 'font-weight: bold'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir un mot de passe.'
                        ]),
                        new Length([
                            'min' => 8,
                            'max' => 255,
                            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                            'maxMessage' => 'Le mot de passe doit contenir au maximum {{ limit }} caractères.'
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                        'style' => 'font-weight: bold'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez confirmer le mot de passe.'
                        ]),
                        new Length([
                            'min' => 8,
                            'max' => 255,
                            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                            'maxMessage' => 'Le mot de passe doit contenir au maximum {{ limit }} caractères.'
                        ])
                    ]
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '10',
                    'maxlength' => '150'
                ],
                'label' => 'Adresse Email',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'style' => 'font-weight: bold'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse email.'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 150,
                        'minMessage' => 'L\'adresse email doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'adresse email doit contenir au maximum {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('isSubscribedNewsletter', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'label' => ' ~ Cochez cette case si vous voulez vous inscrire à la newsletter ? Vous recevrez des informations sur les nouveautés du site. (Sans publicité)',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
