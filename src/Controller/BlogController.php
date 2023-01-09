<?php

namespace App\Controller;

use DateTime;
use App\Entity\Articles;
use App\Entity\Comments;
use App\Form\CommentType;
use App\Form\ArticlesType;
use App\Form\Blog\Admin\BlogCreateType;
use App\Form\Blog\Admin\BlogUpdateType;
use App\Form\ChercheAnnonceType;
use App\Form\ChercheArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use App\Services\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_blog_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function adminIndex(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('blog/admin/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_blog_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, ArticlesRepository $articlesRepository, UploadService $upload): Response
    {
        $article = new Articles();
        $form = $this->createForm(BlogCreateType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $article->setDate(new DateTime());
            $article->setAuteur($this->getUser());

            // Ont récupère la photo
            $fichier = $form->get('img')->getData();
            //Ont initialise les extensions autorisé
            $validExt = ['image/png', 'image/jpg', 'image/jpeg'];
            //Ont initialise le repertoire
            $directory = 'blog_directory';
            // Ont initialise le nombre d'erreur à zéro
            $errorFormat = 0;

            // Ont vérifie que le type de fichier est valide
            if (!in_array($fichier->getMimetype(), $validExt)) {
                $errorFormat++;
            }

            // Si le format de l'image est valide
            if ($errorFormat === 0) {
                // Ont crée un nom de fichier unique
                $nom = md5(uniqid()) . '.' . $fichier->guessExtension();
                
                
                // Ont copie ensuite l'avatar
                $fichier->move(
                    $this->getParameter($directory),
                    $nom
                );

                // Ont sauvegarde l'avatar en BDD
                $article->setimg($nom);
                $articlesRepository->save($article, true);
            }
            
            $this->addFlash(
                'success',
                "Votre article a bien été enregistré"
            );

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/admin/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_admin_blog_delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $this->addFlash(
            'warning',
            "Votre article a bien été supprimé"
        );

        $articlesRepository->remove($article, true);

        return $this->redirectToRoute('app_admin_blog_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_admin_blog_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(BlogCreateType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ont récupère la photo
            $fichier = $form->get('img')->getData();
            //Ont initialise les extensions autorisé
            $validExt = ['image/png', 'image/jpg', 'image/jpeg'];
            //Ont initialise le repertoire
            $directory = 'blog_directory';
            // Ont initialise le nombre d'erreur à zéro
            $errorFormat = 0;

            if ($fichier) {
                // Ont vérifie que le type de fichier est valide
                if (!in_array($fichier->getMimetype(), $validExt)) {
                    $errorFormat++;
                }

                // Si le format de l'image est valide
                if ($errorFormat === 0) {
                    // Ont crée un nom de fichier unique
                    $nom = md5(uniqid()) . '.' . $fichier->guessExtension();

                    /**
                    * Si ont a déjà un avatar
                    * On supprime l'ancien
                    */
                    if($article->getImg()) {
                        unlink($this->getParameter($directory).'/'.$article->getImg());
                    }

                    // Ont copie ensuite l'avatar
                    $fichier->move(
                        $this->getParameter($directory),
                        $nom
                    );

                    // Ont sauvegarde l'avatar en BDD
                    $article->setimg($nom);
                    
                }
                
            }
            
            $articlesRepository->save($article, true);
            $this->addFlash(
                'success',
                "Votre article a bien été enregistré"
            );

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/admin/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/', name: 'app_blog_index', methods: ['GET', 'POST'])]
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

            return $this->render('blog/index.html.twig', [
                'articles' => $articles,
                'categories' => $categoriesRepository->findAll(),
                'formCherche' => $formCherche,
                'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
            ]);

        }


        return $this->render('blog/index.html.twig', [
            'articles' => $donnees,
            'categories' => $categoriesRepository->findAll(),
            'formCherche' => $formCherche,
            'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
        ]);
    }

    #[Route('/{slug}', name: 'app_blog_categories', methods: ['GET', 'POST'])]
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

            return $this->render('blog/index.html.twig', [
                'articles' => $articles,
                'categories' => $categoriesRepository->findAll(),
                'formCherche' => $formCherche,
                'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
            ]);

        }
        //$categorie = 
        //dd($categoriesRepository->findOneBy(['slug' => $slug])->getArticles());
        return $this->render('blog/index.html.twig', [
            'articles' => $donnees,
            'categories' => $categoriesRepository->findAll(),
            'formCherche' => $formCherche,
            'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
        ]);
    }


    #[Route('/details/{slug}', name: 'app_blog_show', methods: ['GET', 'POST'])]
    public function show($slug, CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository, Request $request, Articles $article, EntityManagerInterface $manager): Response
    {

        $formCherche = $this->createForm(ChercheArticlesType::class);
        $cherche = $formCherche->handleRequest($request);

        if($formCherche->isSubmitted() && $formCherche->isValid()) {

            $page = $request->query->getInt('page', 1);
            $articles = $articlesRepository->cherche($cherche->get('mots')->getData(), $page, 5);

            $formCherche = $this->createForm(ChercheArticlesType::class);

            return $this->render('blog/index.html.twig', [
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

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'categories' => $categoriesRepository->findAll(),
            'form' => $form,
            'formCherche' => $formCherche,
            'derniersArticles' => $articlesRepository->findBy([], ['date' => 'DESC'], 5)
        ]);
    }

}
