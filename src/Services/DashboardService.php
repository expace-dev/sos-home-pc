<?php

namespace App\Services;

use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use App\Repository\FacturesRepository;
use App\Repository\PaiementsRepository;
use App\Repository\TemoignagesRepository;
use App\Repository\TicketsRepository;
use App\Repository\UsersRepository;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class DashboardService {

    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private UsersRepository $usersRepository,
        private TicketsRepository $ticketsRepository,
        private TemoignagesRepository $temoignagesRepository,
        private ArticlesRepository $articlesRepository,
        private CommentsRepository $commentsRepository,
        private FacturesRepository $facturesRepository,
        private Security $security,
        private PaiementsRepository $paiementsRepository

    )
    {
    }

    public function createChartUser(int $annee) {

        $inscriptions = [];
        $interventions = [];
        $temoignages = [];
        for ($i=1; $i < 13; $i++) {

            $date = new DateTime($annee. '-' . $i . '-01');

            $inscriptions[] = $this->usersRepository->nombreInscriptionMensuel($date->format('Y'), $date->format('m'));
            $interventions[] = $this->ticketsRepository->nombreInterventionMensuel($date->format('Y'), $date->format('m'));
            $temoignages[] = $this->temoignagesRepository->NombreTemoignageMensuel($date->format('Y'), $date->format('m'));

        }

        $chartUtilisateurs = $this->chartBuilder->createChart(Chart::TYPE_LINE);

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

        return $chartUtilisateurs;
    }

    public function createChartBlog($annee) {

        $articles = [];
        $commentaires = [];

        for ($i=1; $i < 13; $i++) {
            $date = new DateTime($annee . '-' . $i . '-01');

            $articles[] = $this->articlesRepository->nombreArticlesMensuel($date->format('Y'), $date->format('m'));
            $commentaires[] = $this->commentsRepository->nombreCommentairesMensuel($date->format('Y'), $date->format('m'));
        }

        $chartBlog = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $chartBlog->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Articles',
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'backgroundColor' => 'rgb(54, 162, 235)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'data' => $articles 
                ],
                [
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'label' => 'Commentaires',
                    'backgroundColor' => 'rgb(75, 192, 192)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'data' => $commentaires 
                ],
            ]
        ]);

        $chartBlog->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $chartBlog;
    }

    public function chartClientPaiements($annee) {

        $amountFactures = [];

        

        for ($i=1; $i < 13; $i++) {

            $date = new DateTime($annee . '-' . $i . '-01');

            if ($this->paiementsRepository->amountPaiementMensuelClient($date->format('Y'), $date->format('m'), $this->security->getUser()) === null) {
                $amountPaiements[] = "0";
            }
            else {
                $amountPaiements[] = $this->paiementsRepository->amountPaiementMensuelClient($date->format('Y'), $date->format('m'), $this->security->getUser());
            }
        }

        $chartPaiements = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chartPaiements->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Dépenses',
                    'tension' => 0.2,
                    'radius' => 5,
                    'borderWidth' => 3,
                    'backgroundColor' => 'rgb(54, 162, 235)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'data' => $amountPaiements 
                ],
            ]
        ]);

        $chartPaiements->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $chartPaiements;
    }
}