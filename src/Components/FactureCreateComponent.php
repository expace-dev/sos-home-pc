<?php

namespace App\Components;

use App\Entity\Factures;
use App\Entity\Users;
use App\Form\Compta\Admin\FacturesType;
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

#[AsLiveComponent('facture_create')]
class FactureCreateComponent extends AbstractController {

    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'data')]
    public ?Factures $facture = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(FacturesType::class, $this->facture);
    }
}