<?php

namespace App\Form\Booking\Admin;

use App\Entity\Users;
use App\Entity\Booking;
use App\Form\UserAutocompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserAutocompleteField::class, [
                'constraints' => [
                    new NotNull(['message' => 'Veuillez sélectionner un client'])
                ],
            ])
            ->add('beginAt', HiddenType::class)
            ->add('endAt', HiddenType::class)
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Dépannage à distance' => 'Dépannage à distance',
                    'Dépannage à domicile' => 'Dépannage à domicile'
                ],
                'placeholder' => 'Sélectionnez le type d\'intervention',
                'constraints' => [
                    new NotNull(['message' => 'Choisissez le type d\'intervention'])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères'
                    ]),
                ],
                
                'attr' => [
                    'rows' => '10',
                    'placeholder' => 'Description du problème',
                    'class' => 'mb-3'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
