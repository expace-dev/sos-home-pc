<?php

namespace App\Form;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class UserAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Users::class,
            'placeholder' => 'Choisissez un client',
            'choice_label' => 'fullName',
            'constraints' => [
                new NotNull(['message' => 'Veuillez sélectionner un client'])
            ],
            'label' => 'Client',

            'query_builder' => function(UsersRepository $usersRepository) {
                return $usersRepository->createQueryBuilder('users');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
