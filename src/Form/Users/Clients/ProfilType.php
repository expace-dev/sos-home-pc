<?php

namespace App\Form\Users\Client;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email'
                ],
                'label' => 'Email',
                'constraints' => [
                    new Email(['message' => 'Entrez un Email valide']),
                    new NotNull(['message' => 'Entrez un Email'])
                ]
            ])
            ->add('avatar', FileType::class, [
                'attr' => [
                    'is' => 'drop-files',
                    'label' => 'Déposez votre photo de profil ou cliquez pour ajouter.',
                    'help' => 'Seul les fichiers jpg jpeg et png sont accepté',
                ],
                'label' => false,
                'multiple' => false,
                'data_class' => null,
                'mapped' => false,
                'required' => false,
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom'
                ],
                'label' => 'Nom',
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
                    new Regex([
                        'pattern' => '/^([a-zA-Z]+)$/',
                        'message' => 'Uniquement des lettres'
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
                'label' => 'Prénom',
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
                    new Regex([
                        'pattern' => '/^([a-zA-Z]+)$/',
                        'message' => 'Uniquement des lettres'
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
                'label' => 'Adresse',
                'constraints' => [
                    new NotNull([
                        'message' => 'Entrez ue adresse'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 200,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'

                    ])
                ]
            ])
            ->add('codePostal', HiddenType::class)
            ->add('ville', HiddenType::class)
            ->add('pays', HiddenType::class)
            ->add('societe', TextType::class, [
                'attr' => [
                    'placeholder' => 'Société'
                ],
                'label' => 'Société',
                'required' => false
            ])
            ->add('telephone', TelType::class, [
                'attr' => [
                    'placeholder' => 'Téléphone'
                ],
                'label' => 'Téléphone',
                'constraints' => [
                    new NotBlank(['message' => 'Entrez un téléphone'])
                ]
                
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
