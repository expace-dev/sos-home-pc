<?php

namespace App\Controller\Client;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panel/paiement')]
class PaiementController extends AbstractController
{

    #[Route('/', name: 'app_paiement_index', methods:['GET'])]
    public function index()
    {
        return $this->render('paiement/index.html.twig');
    }

}