<?php

namespace App\Controller\Client;

use Stripe\Stripe;
use App\Entity\Factures;
use App\Entity\Paiements;
use Stripe\Checkout\Session;
use App\Repository\FacturesRepository;
use App\Repository\PaiementsRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panel/paiement')]
class PaiementController extends AbstractController
{

    #[Route('/', name: 'app_paiement_index', methods:['GET'])]
    public function index(PaiementsRepository $paiementsRepository)
    {
        $paiements = $paiementsRepository->findBy(['client' => $this->getUser()]);


        return $this->render('paiement/index.html.twig', [
            'paiements' => $paiements,
        ]);
    }

    #[Route('/webhook', name: 'app_paiement_webhook', methods:['POST'])]
    public function webhook(Request $request, FacturesRepository $facturesRepository, PaiementsRepository $paiementsRepository)
    {


        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = 'sk_test_AEgwPLi1oCP4VrRgPjUoiUWL00bWphQrlb';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        

        try {
            $event = \Stripe\Webhook::constructEvent(
              $payload, $sig_header, $endpoint_secret
            );
        } 
        catch(\UnexpectedValueException $e) {
            // Invalid payload
            return new Response(Response::HTTP_BAD_REQUEST);
            exit();
        } 
        catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return new Response(Response::HTTP_BAD_REQUEST);
            exit();
        }


        if ($event->type === 'checkout.session.completed') {

            $facture = $facturesRepository->findOneBy(['payment_intent' => $event->data->object->payment_intent]);

            $facture->setStatut($event->data->object->status);

            $paiement = new Paiements();

            $paiement->setDate(new DateTime())
                    ->setMontant($event->data->object->amount_total / 100)
                    ->setStatut($event->data->object->status)
                    ->setFacture($facture)
                    ->setClient($facture->getClient());

            $facturesRepository->save($facture, true);
            $paiementsRepository->save($paiement, true);

        }
        return new Response();


    }
    
    #[Route('/success', name: 'app_paiement_success', methods:['GET'])]
    public function success(FacturesRepository $facturesRepository)
    {
        $factures = $facturesRepository->findBy(['client' => $this->getUser()]);

        $this->addFlash(
            'success',
            "Le paiement a été enregistré avec succès"
        );

        return $this->render('factures/index.html.twig', [
            'factures' => $factures,
        ]);
    }

    #[Route('/error', name: 'app_paiement_error', methods:['GET'])]
    public function error(FacturesRepository $facturesRepository)
    {
        $factures = $facturesRepository->findBy(['client' => $this->getUser()]);

        $this->addFlash(
            'danger',
            "Il y a eu une erreur lors de votre paiement"
        );

        return $this->render('factures/index.html.twig', [
            'factures' => $factures,
        ]);
    }
    #[Route('/{id}', name: 'app_paiement', methods:['GET'])]
    public function paie(Factures $facture, FacturesRepository $facturesRepository)
    {
        Stripe::setApiKey('sk_test_AEgwPLi1oCP4VrRgPjUoiUWL00bWphQrlb');

        


        $checkout_session = Session::create([
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => $facture->getTitle()
                    ],
                    'unit_amount' => $facture->getAmount() * 100
                ]
            ]],
            'mode' => 'payment',
            'success_url' => 'https://www.sos-home-pc.eu/panel/paiement/success',
            'cancel_url' => 'https://www.sos-home-pc.eu/panel/paiement/error',
        ]);

        $facture->setPaymentIntent($checkout_session->payment_intent);
        $facturesRepository->save($facture, true);
        //dd($facture);


        return $this->redirect($checkout_session->url);

        //dd($checkout_session);
    }

    
}