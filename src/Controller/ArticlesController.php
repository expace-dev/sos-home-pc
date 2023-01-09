<?php

namespace App\Controller;

use DateTime;
use App\Entity\Articles;
use App\Entity\Comments;
use App\Form\CommentType;
use App\Form\ArticlesType;
use App\Form\ChercheAnnonceType;
use App\Form\ChercheArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/articles')]
class ArticlesController extends AbstractController
{
    #[Route('/', name: 'app_articles_index', methods: ['GET', 'POST'])]
    public function index(PaginatorInterface $paginator, Request $request, ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): Response
    {
        $formCherche = $this->createForm(ChercheArticlesType::class);
        
        $cherche = $formCherche->handleRequest($request);

        $page = $request->query->getInt('page', 1);

        $donnees = $articlesRepository->findArticles($page, 5);

        //dd($donnees);

        if($formCherche->isSubmitted() && $formCherche->isValid()) {

            $page = $request->query->getInt('page', 1);
            $articles = $articlesRepository->cherche($cherche->get('mots')->getData(), $page, 5);

            $formCherche = $this->createForm(ChercheArticlesType::class);

            return $this->render('articles/index.html.twig', [
                'articles' => $articles,
                'categories' => $categoriesRepository->findAll(),
                'formCherche' => $formCherche,
                'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
            ]);

        }


        return $this->render('articles/index.html.twig', [
            'articles' => $donnees,
            'categories' => $categoriesRepository->findAll(),
            'formCherche' => $formCherche,
            'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
        ]);
    }

    #[Route('/{slug}', name: 'app_articles_categories', methods: ['GET', 'POST'])]
    public function categoriesAnnonce(Request $request, $slug, ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): Response
    {
        $formCherche = $this->createForm(ChercheArticlesType::class);
        $cherche = $formCherche->handleRequest($request);

        $page = $request->query->getInt('page', 1);

        $donnees = $articlesRepository->findArticles($page, 5);

        if($formCherche->isSubmitted() && $formCherche->isValid()) {

            $page = $request->query->getInt('page', 1);
            $articles = $articlesRepository->cherche($cherche->get('mots')->getData(), $page, 5);

            $formCherche = $this->createForm(ChercheArticlesType::class);

            return $this->render('articles/index.html.twig', [
                'articles' => $articles,
                'categories' => $categoriesRepository->findAll(),
                'formCherche' => $formCherche,
                'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
            ]);

        }
        //$categorie = 
        //dd($categoriesRepository->findOneBy(['slug' => $slug])->getArticles());
        return $this->render('articles/index.html.twig', [
            'articles' => $donnees,
            'categories' => $categoriesRepository->findAll(),
            'formCherche' => $formCherche,
            'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
        ]);
    }


    #[Route('/details/{slug}', name: 'app_articles_show', methods: ['GET', 'POST'])]
    public function show($slug, CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository, Request $request, Articles $article, EntityManagerInterface $manager): Response
    {

        $formCherche = $this->createForm(ChercheArticlesType::class);
        $cherche = $formCherche->handleRequest($request);

        if($formCherche->isSubmitted() && $formCherche->isValid()) {

            $page = $request->query->getInt('page', 1);
            $articles = $articlesRepository->cherche($cherche->get('mots')->getData(), $page, 5);

            $formCherche = $this->createForm(ChercheArticlesType::class);

            return $this->render('articles/index.html.twig', [
                'articles' => $articles,
                'categories' => $categoriesRepository->findAll(),
                'formCherche' => $formCherche,
                'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
            ]);

        }

        $commentaires = new Comments();
        $form = $this->createForm(CommentType::class, $commentaires);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commentaires->setCreatedAt(new DateTime());
            $commentaires->setArticles($article);
            $commentaires->setAuteur($this->getUser());


            // On récupère le contenu du champ parentid
            $parentid = $form->get("parentid")->getData();

            // On va chercher le commentaire correspondant
            if($parentid != null){
                $parent = $manager->getRepository(Comments::class)->find($parentid);
            }

            // On définit le parent
            $commentaires->setParent($parent ?? null);

            $manager->persist($commentaires);
            $manager->flush();

            $this->addFlash('primary', 'Votre commentaire a bien été publié');

            $form = $this->createForm(CommentType::class);


        }

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'categories' => $categoriesRepository->findAll(),
            'form' => $form,
            'formCherche' => $formCherche,
            'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
        ]);
    }


}
