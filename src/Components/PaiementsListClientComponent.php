<?php

namespace App\Components;

use App\Repository\FacturesRepository;
use App\Repository\PaiementsRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('paiements_list_client')]
class PaiementsListClientComponent {

    use DefaultActionTrait;

    public function __construct(private PaiementsRepository $paiementsRepository, private RequestStack $requestStack, private Security $security)
    {
    }

    public function getAllPaiements(): array {

        $request = $this->requestStack->getCurrentRequest();
        
        $page = $request->query->getInt('page', 1);

        $user = $this->security->getUser();

        return $this->paiementsRepository->findPaiementClient($page, 15, $user);
    }
    
}