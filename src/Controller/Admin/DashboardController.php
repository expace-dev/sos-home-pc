<?php

namespace App\Controller\Admin;

use App\Repository\ArticlesRepository;
use App\Repository\BookingRepository;
use App\Repository\CommentsRepository;
use App\Repository\UsersRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\FacturesRepository;
use App\Repository\PaiementsRepository;
use App\Repository\TemoignagesRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin')]
class DashboardController extends AbstractController
{
    #[Route('/statistiques', name: 'app_admin_dashboard')]
    public function index(
        UsersRepository $usersRepository, 
        FacturesRepository $facturesRepository,
        PaiementsRepository $paiementsRepository,
        BookingRepository $bookingRepository,
        TemoignagesRepository $temoignagesRepository, 
        ChartBuilderInterface $chartBuilder,
        ArticlesRepository $articlesRepository,
        CommentsRepository $commentsRepository
    ): Response
    {
        $now = new DateTime();
        $annee = $now->format('Y');

        $inscriptions = [];
        $interventions = [];
        $temoignages = [];
        $paiements = [];
        $articles = [];
        $commentaires = [];
        for ($i=1; $i < 13; $i++) { 
            $date = new DateTime($annee. '-' . $i . '-01');

            $inscriptions[] = $usersRepository->nombreInscriptionMensuel($date->format('Y'), $date->format('m'));
            $interventions[] = $bookingRepository->nombreInterventionMensuel($date->format('Y'), $date->format('m'));
            $temoignages[] = $temoignagesRepository->NombreTemoignageMensuel($date->format('Y'), $date->format('m'));

            if ($paiementsRepository->nombrePaiementMensuel($date->format('Y'), $date->format('m')) === null) {
                $paiements[] = "0";
            }
            else {
                $paiements[] = $paiementsRepository->nombrePaiementMensuel($date->format('Y'), $date->format('m'));
            }

            $articles[] = $articlesRepository->nombreArticlesMensuel($date->format('Y'), $date->format('m'));
            $commentaires[] = $commentsRepository->nombreCommentairesMensuel($date->format('Y'), $date->format('m'));
        }


        $chartUtilisateurs = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chartUtilisateurs->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Inscriptions',
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'backgroundColor' => 'rgb(54, 162, 235)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'data' => $inscriptions 
                ],
                [
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'label' => 'Interventions',
                    'backgroundColor' => 'rgb(75, 192, 192)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'data' => $interventions 
                ],
                [
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'label' => 'Témoignages',
                    'backgroundColor' => 'rgba(153, 102, 255)',
                    'borderColor' => 'rgb(153, 102, 255)',
                    'data' => $temoignages 
                ],
            ],
        ]);

        $chartUtilisateurs->setOptions([
            'maintainAspectRatio' => false,
        ]);

        $chartGains = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chartGains->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Paiements',
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'backgroundColor' => 'rgb(54, 162, 235)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'data' => $paiements 
                ],
            ],
        ]);

        $chartGains->setOptions([
            'maintainAspectRatio' => false,
        ]);

        $chartBlog = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chartBlog->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'label' => 'Articles',
                    'backgroundColor' => 'rgb(75, 192, 192)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'data' => $articles 
                ],
                [
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'label' => 'Commentaires',
                    'backgroundColor' => 'rgba(153, 102, 255)',
                    'borderColor' => 'rgb(153, 102, 255)',
                    'data' => $commentaires 
                ],
            ],
        ]);

        $chartBlog->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $this->render('dashboard/admin/index.html.twig', [
            'clients' => $usersRepository->count([]),
            'factures' => $facturesRepository->count([]),
            'interventions' => $bookingRepository->count([]),
            'temoignages' => $temoignagesRepository->count([]),
            'chart_utilisateurs' => $chartUtilisateurs,
            'chart_gains' => $chartGains,
            'chart_blog' => $chartBlog

        ]);
    }
}
