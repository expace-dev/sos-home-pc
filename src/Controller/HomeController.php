<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\TemoignagesRepository;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TemoignagesRepository $temoignagesRepository, Request $request, MailerService $mailer): Response
    {

        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);
        $url = $this->generateUrl('app_home', [
            '_fragment' => 'contact'
        ]);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $contact->getData();
            $content = nl2br($contactFormData['message']);
            $mailer->sendEmail(
                from: $contactFormData['email'], 
                name: $contactFormData['nom'], 
                template: 'emails/contact.html.twig', 
                subject: $contactFormData['sujet'], 
                content: $content
            );

            $this->addFlash('primary', 'Votre message a bien été envoyé<br>Nous allons vous répondre dans les meilleurs délais');
            return $this->redirect($url);

        }

        return $this->render('home/index.html.twig', [
            'temoignages' => $temoignagesRepository->returnTemoignages(),
            'contactForm' => $form->createView()
        ]);
    }
}
