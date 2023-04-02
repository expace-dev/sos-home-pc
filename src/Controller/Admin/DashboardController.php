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
use App\Services\DashboardService;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dashboard')]
    public function dashboardAdmin(
        UsersRepository $usersRepository, 
        FacturesRepository $facturesRepository,
        PaiementsRepository $paiementsRepository,
        BookingRepository $bookingRepository,
        TemoignagesRepository $temoignagesRepository, 
        ChartBuilderInterface $chartBuilder,
        ArticlesRepository $articlesRepository,
        CommentsRepository $commentsRepository,
        DashboardService $dashboardService
    ): Response
    {
        $now = new DateTime();
        $annee = $now->format('Y');

        $paiements = [];
        for ($i=1; $i < 13; $i++) { 
            $date = new DateTime($annee. '-' . $i . '-01');


            if ($paiementsRepository->nombrePaiementMensuel($date->format('Y'), $date->format('m')) === null) {
                $paiements[] = "0";
            }
            else {
                $paiements[] = $paiementsRepository->nombrePaiementMensuel($date->format('Y'), $date->format('m'));
            }

        }


        

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


        return $this->render('dashboard/admin/index.html.twig', [
            'clients' => $usersRepository->count([]),
            'factures' => $facturesRepository->count([]),
            'interventions' => $bookingRepository->count([]),
            'temoignages' => $temoignagesRepository->count([]),
            'chart_utilisateurs' => $dashboardService->createChartUser($annee),
            'chart_gains' => $chartGains,
            'chart_blog' => $dashboardService->createChartBlog($annee)

        ]);
    }

    #[Route('/panel', name: 'app_client_dashboard')]
    public function dashboardClient(DashboardService $dashboardService) {

        $now = new DateTime();
        $annee = $now->format('Y');

        return $this->render('dashboard/client/index.html.twig', [
            'chart_paiements' => $dashboardService->chartClientPaiements($annee)
        ]);
    }
}
