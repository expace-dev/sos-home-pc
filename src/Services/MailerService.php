<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerService {
    public function __construct(private MailerInterface $mailer)
    {
        
    }

    public function sendEmail(
        $from = '', 
        $name = '', 
        $template = '', 
        $subject = '', 
        $content = '', 
        $to = 'contact@sos-home-pc.fr'
        ):void {

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject('Demande de contact de ' . $name)
            ->htmlTemplate($template)
            ->context([
                'nom' => $name,
                'sujet' => $subject,
                'message' => $content
            ]);

        $this->mailer->send($email);

    }
}