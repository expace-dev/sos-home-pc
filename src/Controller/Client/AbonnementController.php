<?php

namespace App\Controller\Client;

use App\Entity\Abonnements;
use App\Services\StripeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panel/abonnement')]
class AbonnementController extends AbstractController
{
    #[Route('/', name: 'app_client_abonnement')]
    public function index(): Response
    {
        return $this->render('abonnement/index.html.twig');
    }

    #[Route('/gestion', name: 'app_client_gerer_abonnement')]
    public function gestionAbonnement(StripeService $stripeService): Response
    {

        return $this->redirect($stripeService->portail());
    }

    #[Route('/annulation', name: 'app_client_annule_abonnement')]
    public function removeAbonnement(StripeService $stripeService): Response
    {
        return $this->redirect($stripeService->removeAbonnement());
    }

    #[Route('/commande/{slug}', name: 'app_client_commande_abonnement')]
    public function commande(Request $request, StripeService $stripeService): Response
    {
        //dd($request->get('slug'));
        
        if ($request->get('slug') === 'basic') {
            $stripeService->createFact();
        }
        else {
            return $this->redirect($stripeService->addAbonnement($request->get('slug')));
        }
    }

    
}
