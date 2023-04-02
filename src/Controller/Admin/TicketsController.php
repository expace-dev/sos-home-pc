<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Tickets;
use App\Form\MessagesType;
use App\Entity\MessagesTickets;
use App\Form\Admin\TicketsType;
use App\Repository\TicketsRepository;
use App\Repository\MessagesTicketsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/interventions')]
class TicketsController extends AbstractController
{
    #[Route('/', name: 'app_admin_tickets_index')]
    public function index(): Response
    {
        return $this->render('tickets/admin/index.html.twig');
    }

    #[Route('/creation', name: 'app_admin_tickets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketsRepository $ticketsRepository): Response
    {
        $ticket = new Tickets();
        $form = $this->createForm(TicketsType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $ticket->setAuteur($ticket->getAuteur());
            $ticketsRepository->save($ticket, true);

            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Votre ticket a bien été enregistré');

            return $this->redirectToRoute('app_admin_tickets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tickets/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tickets_show', methods: ['GET', 'POST'])]
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

            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Votre message a bien été enregistré');

            return $this->redirectToRoute('app_admin_tickets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tickets/show.html.twig', [
            'ticket' => $ticket,
            'form' => $form
        ]);
    }

    #[Route('/{id}/edition', name: 'app_admin_tickets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tickets $ticket, TicketsRepository $ticketsRepository): Response
    {
        $form = $this->createForm(TicketsType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketsRepository->save($ticket, true);

            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Votre ticket a bien été enregistré');

            return $this->redirectToRoute('app_admin_tickets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tickets/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'app_admin_tickets_delete', methods: ['GET'])]
    public function delete(Tickets $ticket, TicketsRepository $ticketsRepository): Response
    {
        if ($ticket->getStatut() === 'en_attente') {
            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Le ticket a bien été supprimé');
            $ticketsRepository->remove($ticket, true);
        }
        else {
            $this->addFlash('danger', '<span class="me-2 fa fa-circle-exclamation fa-1x"></span>Vous ne pouvez plus supprimer ce ticket');
        }
        

        return $this->redirectToRoute('app_admin_tickets_index', [], Response::HTTP_SEE_OTHER);
    }
}
