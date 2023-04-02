<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Email'
                ],
                'constraints' => [
                    new NotNull(['message' => 'Veuillez renseigner un E-mail valide']),
                    new Email(['message' => 'Veuillez renseigner un E-mail valide'])
                ]
            ])
            ->add('username', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Pseudo'
                ],
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte les conditions générales',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'always_empty' => false,
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
                        'pattern' => '/[1-9]/',
                        'message' => 'Au moins un chiffre'
                    ]),
                    new Length([
                        'min' => 14,
                        'minMessage' => 'Au moins {{ limit }} caractères',
                    ]),
                    new NotCompromisedPassword(['message' => 'Ce mot de passe est compromis']),
                ],
                'help' => 'Minimum huit caractères, au moins une lettre, un chiffre et un caractère spécial',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'attr' => [
                    'placeholder' => 'Mot de passe'
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
