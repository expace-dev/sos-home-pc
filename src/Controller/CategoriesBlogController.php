<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesBlogType;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categories/blog')]
class CategoriesBlogController extends AbstractController
{
    #[Route('/', name: 'app_categories_blog_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('categories_blog/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categories_blog_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, CategoriesRepository $categoriesRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesBlogType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->save($category, true);

            $this->addFlash(
                'success',
                "Votre catégorie a bien été enregistré"
            );

            return $this->redirectToRoute('app_categories_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories_blog/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categories_blog_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $form = $this->createForm(CategoriesBlogType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->save($category, true);

            $this->addFlash(
                'success',
                "Votre catégorie a bien été enregistré"
            );

            return $this->redirectToRoute('app_categories_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories_blog/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_categories_blog_delete', methods: ['GET'])]
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $categoriesRepository->remove($category, true);

        $this->addFlash(
            'warning',
            "Votre catégorie a bien été supprimé"
        );

        return $this->redirectToRoute('app_categories_blog_index', [], Response::HTTP_SEE_OTHER);
    }
}
