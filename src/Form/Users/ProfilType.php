<?php

namespace App\Form\Users;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('societe', TextType::class, [
                'label' => 'Nom de l’entreprise',
                'trim' => false,
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom*',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez un Nom'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 30,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'
                    ]),
                    new Regex([
                        'pattern' => '/^([a-zA-Z]+)$/',
                        'message' => 'Uniquement des lettres'
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom*',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez un prénom'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 30,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'
                    ]),
                    new Regex([
                        'pattern' => '/^([a-zA-Z]+)$/',
                        'message' => 'Uniquement des lettres'
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse*',
                'trim' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'data-live-ignore' => 'true'
                ],
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
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone*',
                'trim' => false,
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez un téléphone'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
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
            ->add('email', EmailType::class, [
                'label' => 'E-mail*',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Email(['message' => 'Entrez un E-mail valide']),
                    new NotNull(['message' => 'Entrez un E-mail']),
                ]
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
            ->add('avatar', FileType::class, [
                'attr' => [
                    'is' => 'drop-files',
                    'label' => 'Déposez votre photo ou cliquez pour ajouter.',
                    'help' => 'Seul les fichiers jpg jpeg et png sont accepté',
                ],
                'label' => false,
                'multiple' => false,
                'data_class' => null,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Seul les images sont acceptés'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Dites nous en plus sur vous',
                'trim' => false,
                'attr' => [
                    'rows' => 5
                ],
                'required' => false
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook',
                'attr' => [
                    'placeholder' => 'Url de votre page Facebook'
                ],
                'required' => false
            ])
            ->add('tweeter', TextType::class, [
                'label' => 'Tweeter',
                'attr' => [
                    'placeholder' => 'Url de votre page Tweeter'
                ],
                'required' => false
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'Linkedin',
                'attr' => [
                    'placeholder' => 'Url de votre page Linkedin'
                ],
                'required' => false
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
