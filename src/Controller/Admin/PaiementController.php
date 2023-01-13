<?php

namespace App\Controller\Admin;

use App\Repository\PaiementsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/paiement')]
class PaiementController extends AbstractController
{
    #[Route('/', name: 'app_admin_paiement_index', methods:['GET'])]
    public function index(PaiementsRepository $paiementsRepository)
    {
        $paiements = $paiementsRepository->findAll();


        return $this->render('paiement/index.html.twig', [
            'paiements' => $paiements,
        ]);
    }
}
