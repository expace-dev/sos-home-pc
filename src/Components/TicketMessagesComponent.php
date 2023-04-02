<?php

namespace App\Components;

use App\Repository\MessagesTicketsRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsTwigComponent('ticket_messages')]
class TicketMessagesComponent extends AbstractController {
    
    public int $id;

    public function __construct(private MessagesTicketsRepository $messagesTicketsRepository)
    {
        
    }



    public function getMessages() {
        
        
        return $this->messagesTicketsRepository->findBy(['messages' => $this->id]);
    }
}