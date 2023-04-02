<?php

namespace App\Form\Admin;

use App\Entity\Tickets;
use App\Form\UserAutocompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TicketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteur', UserAutocompleteField::class)
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotNull(['message' => 'Veillez donner un titre']),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                        'max' => 180,
                        'maxMessage' => 'Trop long, maximum {{ limit }} caractères'

                    ]),
                ],
                'trim' => false,
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Détaillez le problème',
                'required' => false,
                'row_attr' => [
                    'data-live-ignore' => 'true'
                ],
                'constraints' => [
                    new NotNull(['message' => 'Veuillez détailler votre probleme']),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Trop court, minimum {{ limit }} caractères',
                    ]),
                ],
                'attr' => [
                    'class' => 'editor'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tickets::class,
        ]);
    }
}
