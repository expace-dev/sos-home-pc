<?php

namespace App\Form\Compta\Admin;

use App\Entity\Users;
use App\Entity\Factures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FacturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'fullName',
                'label' => 'Client',
                'placeholder' => 'Choisissez un client',
                'constraints' => [
                    new NotBlank(['message' => 'Choisissez un client'])
                ],
                'autocomplete' => true,
            ])
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Dépannage à distance' => 'Dépannage à distance',
                    'Dépannage à domicile' => 'Dépannage à domicile'
                ],
                'label' => 'Type d\'intervention',
                'placeholder' => 'Sélectionnez une catégorie',
                'constraints' => [
                    new NotBlank(['message' => 'Sélectionnez le type d\'intervention'])
                ]
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => '6'
                ],
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'Donnez des détails']),
                    new Length([
                        'min' => 20,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 255,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'

                    ])
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Factures::class,
        ]);
    }
}
