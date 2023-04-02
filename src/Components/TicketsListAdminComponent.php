<?php

namespace App\Components;

use App\Repository\TicketsRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('tickets_list_admin')]
class TicketsListAdminComponent {

    use DefaultActionTrait;

    public function __construct(private TicketsRepository $ticketsRepository, private RequestStack $requestStack, private Security $security)
    {
    }

    public function getAllTickets(): array {

        $request = $this->requestStack->getCurrentRequest();
        
        $page = $request->query->getInt('page', 1);

        return $this->ticketsRepository->findTickets($page, 15);
    }
    
}