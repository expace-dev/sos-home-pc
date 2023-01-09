<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comments/blog')]
class CommentsBlogController extends AbstractController
{
    #[Route('/', name: 'app_comments_blog_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('comments_blog/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comments_blog_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Comments $comment, CommentsRepository $commentsRepository): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentsRepository->save($comment, true);

            $this->addFlash(
                'success',
                "Le commentaire a bien été modifié"
            );

            return $this->redirectToRoute('app_comments_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comments_blog/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_comments_blog_delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Comments $comment, CommentsRepository $commentsRepository): Response
    {
            $commentsRepository->remove($comment, true);

            $this->addFlash(
                'warning',
                "Le commentaire a bien été supprimé"
            );

        return $this->redirectToRoute('app_comments_blog_index', [], Response::HTTP_SEE_OTHER);
    }
}
