<?php

namespace App\Components;

use App\Entity\Users;
use App\Form\Users\UsersType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('profil_create_form')]
class ProfilCreateFormComponent extends AbstractController {

    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'data')]
    public ?Users $user = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(UsersType::class, $this->user);
    }
}