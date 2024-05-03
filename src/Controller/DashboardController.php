<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Visitors;
use App\Repository\VisitorsRepository;

#[Route('/dashboard', name: 'app_dashboard')]
class DashboardController extends AbstractController
{
    private $repository;
    public function __construct(private ManagerRegistry $doctrine){
        $this->repository = $doctrine->getRepository(Visitors::class);
    }
    #[Route('/')]
    public function index(VisitorsRepository $visitors): Response
    {
        $websites = $visitors->findUserWebsites(1);
        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'websites' => $websites,
        ]);
    }
    #[Route('/{website}')]
    public function websiteSelected($website, VisitorsRepository $visitors){
        //getting the users' websites
        $websites = $visitors->findUserWebsites(1);
        //getting the number of visits
        $numWebsiteVisits = $visitors->findNumberOfVisits(1, $website);
        $numDirectVisits = $visitors->findNumberOfDirectVisits(1, $website);
        $numSocialMediaVisits = $visitors->findNumberOfSocialMediaVisits(1, $website);
        $numSearchEngines = $visitors->findNumberOfSearchEngines(1, $website);
        //getting the data and filling the json files for each chart
        $lineChartData = $visitors->baseChartQuery(1, $website, "date");
        $visitors->generateJSONFile($lineChartData, "lineChart", "date");

        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'websites' => $websites,
            'websiteSelected' => $website,
            'numWebsiteVisits' => $numWebsiteVisits,
            'numDirectVisits' => $numDirectVisits,
            'numSocialMediaVisits' => $numSocialMediaVisits,
            'numSearchEngines' => $numSearchEngines
        ]);

    }
}
