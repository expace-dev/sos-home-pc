<?php

namespace App\Controller\Client;

use DateTime;
use App\Entity\Tickets;
use App\Form\MessagesType;
use App\Entity\MessagesTickets;
use App\Form\Client\TicketsType;
use App\Repository\TicketsRepository;
use App\Repository\AbonnementsRepository;
use App\Repository\MessagesTicketsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panel/tickets')]
class TicketsController extends AbstractController
{
    #[Route('/', name: 'app_client_tickets_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('tickets/client/index.html.twig');
    }

    #[Route('/new', name: 'app_client_tickets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketsRepository $ticketsRepository, AbonnementsRepository $abonnementsRepository): Response
    {

        if (!$this->getUser()->getAbonnements()) {
            return $this->redirectToRoute('app_client_abonnement', [], Response::HTTP_SEE_OTHER);
        }
        $ticket = new Tickets();
        $form = $this->createForm(TicketsType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticket->setAuteur($this->getUser());
            $ticketsRepository->save($ticket, true);

            return $this->redirectToRoute('app_client_tickets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tickets/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_tickets_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Tickets $ticket, MessagesTicketsRepository $messagesTicketsRepository, TicketsRepository $ticketsRepository): Response
    {
        $message = new MessagesTickets();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message->setCreatedAt(new DateTime());
            $message->setMessages($ticket);
            $message->setAuteur($this->getUser());

            // On récupère le contenu du champ parentid
            $parentid = $form->get("parentid")->getData();

            

            // On va chercher le commentaire correspondant
            if($parentid != null){
                $parent = $messagesTicketsRepository->findOneBy(['id' => $parentid]);
            }
            
            //dd($parent);
            // On définit le parent
            $message->setParent($parent ?? null);

            $messagesTicketsRepository->save($message, true);
            
            $ticket->setStatut('ouverture');
            $ticketsRepository->save($ticket, true);
        }

        return $this->render('tickets/show.html.twig', [
            'ticket' => $ticket,
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_tickets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tickets $ticket, TicketsRepository $ticketsRepository): Response
    {
        $form = $this->createForm(TicketsType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketsRepository->save($ticket, true);

            return $this->redirectToRoute('app_client_tickets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tickets/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_client_tickets_delete', methods: ['GET'])]
    public function delete(Tickets $ticket, TicketsRepository $ticketsRepository): Response
    {
        $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Votre mot de passe a bien été modifié');
        $ticketsRepository->remove($ticket, true);

        return $this->redirectToRoute('app_client_tickets_index', [], Response::HTTP_SEE_OTHER);
    }
}
