<?php

namespace App\Components;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Form\Users\Admin\UsersType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('registration_form')]
class RegistrationFormComponent extends AbstractController {

    use DefaultActionTrait;
    use ComponentWithFormTrait;

    
    #[LiveProp(fieldName: 'data')]
    public ?Users $user = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(RegistrationFormType::class, $this->user);
    }
}