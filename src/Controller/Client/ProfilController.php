<?php

namespace App\Controller\Client;

use DateTime;
use Stripe\Event;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session;
use UnexpectedValueException;
use App\Form\Users\ProfilType;
use App\Services\UploadService;
use App\Form\Users\CredentialsType;
use App\Repository\UsersRepository;
use App\Form\Users\Client\ChangePasswordType;
use App\Repository\AbonnementsRepository;
use App\Services\PaiementService;
use App\Services\StripeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/panel/profil')]
class ProfilController extends AbstractController
{

    public function __construct(
        private UploadService $uploadService
    )
    {
        
    }


    #[Route('/edit', name: 'app_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StripeService $stripeService, UsersRepository $usersRepository, AbonnementsRepository $abonnementsRepository, UploadService $upload, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();

        $profilForm = $this->createForm(ProfilType::class, $user);
        $profilForm->handleRequest($request);
        
        $credentialsForm = $this->createForm(CredentialsType::class, $user);
        $credentialsForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()) {

            if ($profilForm->get('avatar')->getData()) {

                
                // On récupère l'image
                $fichier = $profilForm->get('avatar')->getData();
                if ($user->getAvatar()) {
                    
                    unlink(substr($user->getAvatar(),1));
                }
                // On récupère le dossier de destination
                $directory = 'avatar_directory';
                /**
                * On ajoute l'image et l'utilisateur connecté à l'article
                * et ont upload l'image via UploadService
                */
                $user->setAvatar('/images/avatar/' .$this->uploadService->send($fichier, $directory));
            }

            $user->setFullName($user->getNom(). " " .$user->getPrenom());

            $usersRepository->save($user, true);

            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Votre profil a été enregistré avec succès');

            $stripeService->gestionClient($user);

            return $this->redirectToRoute('app_profil_edit', [], Response::HTTP_SEE_OTHER);
        }

        

        if ($credentialsForm->isSubmitted() && $credentialsForm->isValid()) {

            $verifiedPassword = $encoder->isPasswordValid($user, $credentialsForm->get('ancienPassword')->getData());

            if ($verifiedPassword === false) {
                $this->addFlash('danger', '<span class="me-2 fa fa-circle-exclamation fa-1x"></span>Votre mot de passe est invalide');
                return $this->redirectToRoute('app_profil_edit');
            }
            else {
                if ($credentialsForm->get('plainPassword')->getData() === $credentialsForm->get('ancienPassword')->getData()) {
                    $this->addFlash('danger', '<span class="me-2 fa fa-circle-exclamation fa-1x"></span>Votre mot de passe correspond à celui enregistré');
                    
                    return $this->redirectToRoute('app_profil_edit');
                }
                else {
                    $passwordEncoded = $encoder->hashPassword(
                        $user,
                        $credentialsForm->get('plainPassword')->getData()
                    );
                    $user->setPassword($passwordEncoded);
                    $usersRepository->save($user, true);
                    $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Votre mot de passe a bien été modifié');
                    return $this->redirectToRoute('app_profil_edit');
                }
            }


            return $this->redirectToRoute('app_profil_edit', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'profilForm' => $profilForm,
            'credentialsForm' => $credentialsForm,
        ]);
    }

    #[Route('/webhook', name: 'app_profil_webhook', methods:['POST'])]
    public function webhook(Request $request, StripeService $stripeService)
    {
       
        $stripeService->verifPay();

        return new Response();
    }
    


}
