<?php

namespace App\Components;

use App\Repository\FacturesRepository;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('factures_list_admin')]
class FacturesListAdminComponent {

    use DefaultActionTrait;

    public function __construct(private FacturesRepository $facturesRepository, private RequestStack $requestStack)
    {
    }

    public function getAllFactures(): array {

        $request = $this->requestStack->getCurrentRequest();
        
        $page = $request->query->getInt('page', 1);

        return $this->facturesRepository->findFactures($page, 15);
    }
    
}