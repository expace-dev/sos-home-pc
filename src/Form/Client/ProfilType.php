<?php

namespace App\Form\Client;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre Email'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Email'
                ]

            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre Nom'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('adresse', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre adresse'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('codePostal', HiddenType::class, [
                'required' => true
            ])
            ->add('ville', HiddenType::class, [
                'required' => true
            ])
            ->add('pays', HiddenType::class, [
                'required' => true
            ])
            ->add('societe', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Société'
                ]
            ])
            ->add('telephone', TelType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Téléphone'
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
