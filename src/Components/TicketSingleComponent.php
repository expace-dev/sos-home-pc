<?php

namespace App\Components;

use App\Entity\Articles;
use App\Entity\Tickets;
use App\Repository\ArticlesRepository;
use App\Repository\TicketsRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('ticket_single')]
class TicketSingleComponent {
    
    public int $id;

    public function __construct(private TicketsRepository $ticketsRepository)
    {
        
    }

    public function getTicket(): Tickets {

        return $this->ticketsRepository->find($this->id);

    }
}