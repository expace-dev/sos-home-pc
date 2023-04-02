<?php

namespace App\Components;

use App\Entity\Tickets;
use App\Form\Admin\TicketsType;
use App\Form\Blog\Admin\ArticleType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('tickets_form_admin')]
class TicketsFormAdminComponent extends AbstractController {

    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'data')]
    public ?Tickets $ticket = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TicketsType::class, $this->ticket);
    }
    
}