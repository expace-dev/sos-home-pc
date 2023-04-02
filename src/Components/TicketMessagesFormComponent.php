<?php

namespace App\Components;

use App\Entity\Comments;
use App\Entity\MessagesTickets;
use App\Form\Blog\Client\CommentType;
use App\Form\MessagesType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('ticket_messages_form')]
class TicketMessagesFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'data')]
    public ?MessagesTickets $message = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(MessagesType::class, $this->message);
    }
}