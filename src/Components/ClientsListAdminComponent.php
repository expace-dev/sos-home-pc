<?php

namespace App\Components;

use App\Repository\UsersRepository;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('clients_list_admin')]
class ClientsListAdminComponent {

    use DefaultActionTrait;

    public function __construct(private UsersRepository $usersRepository, private RequestStack $requestStack)
    {
    }

    public function getAllClient(): array {

        $request = $this->requestStack->getCurrentRequest();
        
        $page = $request->query->getInt('page', 1);

        return $this->usersRepository->findUsers($page, 15);
    }
    
}