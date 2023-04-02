<?php

namespace App\Controller\Client;

use App\Entity\Factures;
use App\Repository\FacturesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/panel/factures')]
class FacturesController extends AbstractController
{
    #[Route('/', name: 'app_factures_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('factures/index.html.twig');
    }

}
