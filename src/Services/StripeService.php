<?php

namespace App\Services;

use DateTime;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\Invoice;
use Stripe\Webhook;
use Stripe\Customer;
use Stripe\InvoiceItem;
use Stripe\Subscription;
use App\Entity\Abonnements;
use App\Entity\Factures;
use App\Entity\Paiements;
use Stripe\Checkout\Session;
use Stripe\Service\InvoiceService;
use App\Repository\UsersRepository;
use App\Repository\PaiementsRepository;
use App\Repository\AbonnementsRepository;
use App\Repository\FacturesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Stripe\Exception\UnexpectedValueException;
use Symfony\Component\HttpFoundation\Response;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripeService {

    /**
     *
     * @param [type] $secretKey
     * @param [type] $endpointAbonn
     * @param [type] $urlServer
     * @param Security $security
     * @param AbonnementsRepository $abonnementsRepository
     * @param UsersRepository $usersRepository
     * @param PaiementsRepository $paiementsRepository
     */
    public function __construct(
        private $secretKey, 
        private $endpointAbonn,
        private $urlServer, 
        private Security $security, 
        private AbonnementsRepository $abonnementsRepository,
        private UsersRepository $usersRepository,
        private PaiementsRepository $paiementsRepository,
        private FacturesRepository $facturesRepository
    )
    {
        
    }

    /**
     * Permet de créer un abonnement
     *
     * @param [type] $formule
     * @return string
     */
    public function addAbonnement($formule) {

        $abonnement = new Abonnements();

        if ($formule === 'basic') {
            $mode = "payment";
            $tarif = 29;
            $formule = "Formule basic";
            $productId = "price_1Mp7ePLIXMUuaIL4RBSuJzya";
        }
        if ($formule === 'simple') {
            $mode = "subscription";
            $tarif = 15;
            $formule = "Formule simple";
            $productId = "price_1Mp7hVLIXMUuaIL4b6WVyraR";
        }
        if ($formule === 'avance') {
            $mode = "subscription";
            $tarif = 29;
            $formule = "Formule avancé";
            $productId = "price_1Mp7fkLIXMUuaIL4QtXKjkVH";
        }

        Stripe::setApiKey($this->secretKey);

        $checkout_session = Session::create([
            'line_items' => [[
                'price' => $productId,
                'quantity' => 1,
            ]],
            'mode' => $mode,
            'success_url' => 'https://www.sos-home-pc.eu/panel/paiement/success',
            'cancel_url' => 'https://www.sos-home-pc.eu/panel/paiement/error',
            'customer' => $this->security->getUser()->getCustomer(),
        ]);

        
        $abonnement->setClient($this->security->getUser())
                ->setActif(false)
                ->setPaymentIntent($checkout_session->id)
                ->setPlan($productId)
                ->setFormule($formule);
           //dd($abonnement); 
        $this->abonnementsRepository->save($abonnement, true);
        

        return $checkout_session->url;

    }

    /**
     * Webhook stripe
     *
     * @return void
     */
    public function verifPay() {
        Stripe::setApiKey($this->secretKey);

        $endpoint_secret = $this->endpointAbonn;

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;



        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch(UnexpectedValueException $e) {
            // Invalid payload
            return new Response(Response::HTTP_BAD_REQUEST);
            exit();
        } catch(SignatureVerificationException $e) {
            // Invalid signature
            return new Response(Response::HTTP_BAD_REQUEST);
            exit();
        }

        if ($event->type === 'checkout.session.completed') {
            $abonnement = $this->abonnementsRepository->findOneBy(['paymentIntent' => $event->data->object->id]);

            $abonnement->setSubscribeId($event->data->object->subscription);

            $this->abonnementsRepository->save($abonnement, true);
            
        }

        if ($event->type === 'customer.subscription.created') {
            $abonnement = $this->abonnementsRepository->findOneBy(['subscribeId' => $event->data->object->id]);
            $abonnement->setActif(true)
                       ->setCreatedAt($event->data->object->created)
                       ->setExpiratedAt($event->data->object->current_period_end)
                       ->setSubscribeId($event->data->object->id);
            $this->abonnementsRepository->save($abonnement, true);
            //file_put_contents('created.json', $event);
        }

        if ($event->type === 'customer.subscription.updated') {
            
            if ($event->data->object->plan->id === "price_1Mp7hVLIXMUuaIL4b6WVyraR") {
                $formule = "simple";
            }
            else {
                $formule = "avance";
            }
            
            $abonnement = $this->abonnementsRepository->findOneBy(['subscribeId' => $event->data->object->id]);
            $abonnement->setActif(true)
                       ->setExpiratedAt($event->data->object->current_period_end)
                       ->setPlan($event->data->object->plan->id)
                       ->setFormule($formule);
            $this->abonnementsRepository->save($abonnement, true);

            //file_put_contents('updated.json', $event);
        }
        
        if ($event->type === 'customer.subscription.deleted') {
            $abonnement = $this->abonnementsRepository->findOneBy(['subscribeId' => $event->data->object->id]);
            $this->abonnementsRepository->remove($abonnement, true);
        }

        if ($event->type === 'invoice.created') {

            $stripe = new \Stripe\StripeClient('sk_test_AEgwPLi1oCP4VrRgPjUoiUWL00bWphQrlb');

            $stripe->invoices->finalizeInvoice($event->data->object->id, []);
        }

        if ($event->type === 'invoice.finalized') {

            $facture = new Factures();

            $user = $this->usersRepository->findOneBy(['customer' => $event->data->object->customer]);

            $facture->setClient($user)
                    ->setStatut('en_attente')
                    ->setUrl($event->data->object->invoice_pdf)
                    ->setCreatedAt($event->created)
                    ->setAmount($event->data->object->amount_due / 100)
                    ->setPay($event->data->object->hosted_invoice_url)
                    ->setNumero($event->data->object->number);
            
            $this->facturesRepository->save($facture, true);
            //        file_put_contents('invoice.json', $event);
        }

        if ($event->type === 'charge.succeeded') {
            
            $user = $this->usersRepository->findOneBy(['customer' => $event->data->object->customer]);


            $numInvoice = Invoice::retrieve($event->data->object->invoice);

            $paiement = new Paiements();

            $paiement->setMontant($event->data->object->amount_captured / 100)
                     ->setClient($user)
                     ->setCreatedAt($event->data->object->created)
                     ->setNumero($numInvoice->number)
                     ->setUrl($event->data->object->receipt_url);

            $this->paiementsRepository->save($paiement, true);


        }

        if ($event->type === 'invoice.payment_succeeded') {
            
            $facture = $this->facturesRepository->findOneBy(['numero' => $event->data->object->number]);

            $facture->setStatut('completed');

            $this->facturesRepository->save($facture, true);

        }


    }

    /**
     * Permet d'accéder au portail client
     *
     * @return string
     */
    public function portail() {

        Stripe::setApiKey($this->secretKey);

        // Authenticate your user.
        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $this->security->getUser()->getCustomer(),
            'return_url' => $this->urlServer,
        ]);

        return $session->url;
    }


    /**
     * Permet de modifier un abonnement
     *
     * @return void
     */
    public function updateAbonnement() {

        Stripe::setApiKey($this->secretKey);

        // Authenticate your user.
        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $this->security->getUser()->getCustomer(),
            'return_url' => $this->urlServer,
            'flow_data' => [
                'type' => 'subscription_update',
                'subscription_update' => ['subscription' => $this->security->getUser()->getAbonnements()->getSubscribeId()
],
            ],
        ]);

        return $session->url;
    }

    /**
     * Permet de modifier ou ajouter un moyen de paiement
     *
     * @return void
     */
    public function updateBank() {
        
        Stripe::setApiKey($this->secretKey);

        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $this->security->getUser()->getCustomer(),
            'return_url' => $this->urlServer,
            'flow_data' => ['type' => 'payment_method_update'],
        ]);

        return $session->url;
    }

    /**
     * Permetde résilier un abonnement
     *
     * @return string
     */
    public function removeAbonnement() {
        
        Stripe::setApiKey($this->secretKey);

        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $this->security->getUser()->getCustomer(),
            'return_url' => $this->urlServer,
            'flow_data' => [
                'type' => 'subscription_cancel',
                'subscription_cancel' => ['subscription' => $this->security->getUser()->getAbonnements()->getSubscribeId()
],
            ],
        ]);

        return $session->url;
    }

    /**
     * Permet de créer ou modifier un client
     *
     * @param [type] $user
     * @return void
     */
    public function gestionClient($user) {
        
        Stripe::setApiKey($this->secretKey);

        if (!$user->getCustomer()) {
            $client = Customer::create([
                "email" => $user->getEmail(),
                "name" => $user->getNom() .' ' .$user->getPrenom(),
                "address" => [
                    "line1" => $user->getAdresse(),
                    "postal_code" => $user->getCodePostal(),
                    "city" => $user->getVille(),
                    "country" => $user->getPays()
                ]
            ]);

            $user->setCustomer($client->id);

            $this->usersRepository->save($user, true);
        }
        else {
            $client = Customer::update(
                $user->getCustomer(),
                [
                    "email" => $user->getEmail(),
                    "name" => $user->getNom() .' ' .$user->getPrenom(),
                    "address" => [
                        "line1" => $user->getAdresse(),
                        "postal_code" => $user->getCodePostal(),
                        "city" => $user->getVille(),
                        "country" => $user->getPays()
                    ]
                ]
            );
        }

    }

    public function createFact() {

        Stripe::setApiKey($this->secretKey);

        // Create an Invoice
        $invoice = Invoice::create([
            'customer' => $this->security->getUser()->getCustomer(),
            'collection_method' => 'charge_automatically',
            'pending_invoice_items_behavior' => "exclude",
        ]);

        

        // Create an Invoice Item with the Price, and Customer you want to charge
        $invoiceItem = InvoiceItem::create([
            'customer' => $this->security->getUser()->getCustomer(),
            'price' => 'price_1Mp7ePLIXMUuaIL4RBSuJzya',
            'invoice' => $invoice->id
        ]);

    }

}