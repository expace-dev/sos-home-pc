<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\Users\UsersType;
use App\Form\Users\ProfilType;
use App\Services\UploadService;
use App\Form\Users\CredentialsType;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/clients')]
class UsersController extends AbstractController
{
    /**
     * Fonction permettant de lister les clients
     *
     * @param UsersRepository $usersRepository
     * @return Response
     */
    #[Route('/', name: 'app_admin_users_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('profil/admin/index.html.twig');
    }

    /**
     * Fonction permettant de créer un client
     *
     * @param Request $request
     * @param UsersRepository $usersRepository
     * @param UserPasswordHasherInterface $encoder
     * @return Response
     */
    #[Route('/nouveau', name: 'app_admin_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UsersRepository $usersRepository, UserPasswordHasherInterface $encoder): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Ont crypte le mot de passe
            $user->setPassword($encoder->hashPassword($user, $form->get('plainPassword')->getData()));
            // Ont ajoute le mot de passe à l'user
            
            $usersRepository->save($user, true);

            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Compte client ajouté avec succès');


            return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
     * Fonction permettant de modifier un client
     */
    #[Route('/{id}/editer', name: 'app_admin_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, UsersRepository $usersRepository, UploadService $upload): Response
    {
        $profilForm = $this->createForm(ProfilType::class, $user);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()) {
            $usersRepository->save($user, true);

            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Compte client enregistré avec succès');

            return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
        }

        $credentialsForm = $this->createForm(CredentialsType::class, $user);
        $credentialsForm->handleRequest($request);

        if ($credentialsForm->isSubmitted() && $credentialsForm->isValid()) {
            $usersRepository->save($user, true);

            $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Compte client enregistré avec succès');

            return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'credentialsForm' => $credentialsForm,
            'profilForm' => $profilForm
        ]);
        
    }

    #[Route('/suppression/{id}', name: 'app_admin_users_delete', methods: ['GET'])]
    public function delete(Request $request, Users $user, UsersRepository $usersRepository): Response
    {

        $this->addFlash('success', '<span class="me-2 fa fa-circle-check fa-1x"></span>Compte client supprimé avec succès');

            
        $usersRepository->remove($user, true);

        return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
