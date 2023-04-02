<?php

namespace App\Form\Users;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email*',
                'constraints' => [
                    new Email(['message' => 'Entrez un Email valide']),
                    new NotNull(['message' => 'Entrez un Email valide'])
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom*',
                'trim' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez un Nom'
                    ]),
                    
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 30,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'

                    ]),
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom*',
                'trim' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez un Prénom'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 30,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'

                    ]),
                ]
            ])
            ->add('adresse', TextType::class, [
                'trim' => false,
                'attr' => [
                    'data-live-ignore' => 'true'
                ],
                'label' => 'Adresse*',
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez une adresse'
                    ]),
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal*',
                'trim' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'data-live-ignore' => 'true',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Trop court'
                    ]),
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville*',
                'trim' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'data-live-ignore' => 'true'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez une ville'
                    ]),
                ]
            ])
            ->add('etat', TextType::class, [
                'required' => false,
                'trim' => false,
                'label' => 'Etat',
                'attr' => [
                    'autocomplete' => 'off',
                    'data-live-ignore' => 'true'
                ],
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays*',
                'trim' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'data-live-ignore' => 'true'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez un Pays'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                    ]),
                ]
            ])
            ->add('societe', TextType::class, [
                'label' => 'Société',
                'required' => false,
                'trim' => false
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone*',
                'constraints' => [
                    new NotBlank(['message' => 'Entrez un téléphone'])
                ]
            ])
            ->add('username', TextType::class, [
                'required' => true,
                'label' => 'Nom d\'utilisateur*',
                'constraints' => [
                    new NotNull(['message' => 'Entrez un nom d\'utilisateur valide']),
                    new Regex([
                        'pattern' => '/^\S*$/',
                        'message' => 'Les espaces sont interdits'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 30,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'
                    ]),
                ]
            ])
            ->add('mobile', TelType::class, [
                'label' => 'Mobile',
                'trim' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'required' => false
            ])
            ->add('fax', TelType::class, [
                'label' => 'Fax',
                'trim' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'required' => false
            ])
            ->add('web', UrlType::class, [
                'label' => 'Adresse Web',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'required' => 'false',
                'constraints' => [
                    new Url(['message' => 'Entrez une url valide'])
                ],
                'required' => false
            ])
            ->add('plainPassword', PasswordType::class, [
                'always_empty' => false,
                'label' => 'Mot de passe*',
                'constraints' => [
                    new Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Au moins une lettre minuscule'
                    ]),
                    new Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Au moins une lettre majuscule'
                    ]),
                    new Regex([
                        'pattern' => '/[0-9]/',
                        'message' => 'Au moins un chiffre'
                    ]),
                    new Length([
                        'min' => 14,
                        'minMessage' => 'Au moins {{ limit }} caractères',
                    ]),
                ],
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
