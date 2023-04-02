<?php

namespace App\Components;

use App\Repository\BookingRepository;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('interventions_list_admin')]
class InterventionsListAdminComponent {

    use DefaultActionTrait;

    public function __construct(private BookingRepository $bookingRepository, private RequestStack $requestStack)
    {
    }

    public function getAllBooking(): array {

        $request = $this->requestStack->getCurrentRequest();
        
        $page = $request->query->getInt('page', 1);

        return $this->bookingRepository->findBookings($page, 15);
    }
    
}