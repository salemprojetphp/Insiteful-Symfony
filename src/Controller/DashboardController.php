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
        $visitors->generateJSONFile('', "lineChart", "date");
        $visitors->generateJSONFile('', "browsersDonutChart", "browser");
        $visitors->generateJSONFile('', "devicesDonutChart", "device");
        $visitors->generateJSONFile('', "sources", "source");
        $visitors->generateJSONFile('', "countries", "country");
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
        $this->fillJsonFile(1, $website, "date", $visitors, "lineChart");
        $this->fillJsonFile(1, $website, "browser", $visitors, "browsersDonutChart");
        $this->fillJsonFile(1, $website, "device", $visitors, "devicesDonutChart");
        $this->fillJsonFile(1, $website, "referrer", $visitors, "sources");
        $this->fillJsonFile(1, $website, "country", $visitors, "countries");
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
    public function fillJsonFile($userId, $website, $colonne, VisitorsRepository $visitors, $json){
        //getting the data and filling the json files for each chart
        $lineChartData = $visitors->baseChartQuery($userId, $website, $colonne);
        $data = array();
        for($i = 0; $i < count($lineChartData); $i++){
            if(is_object($lineChartData[$i][$colonne]) && $lineChartData[$i][$colonne] instanceof \DateTime){
                $dateString = $lineChartData[$i][$colonne]->format('Y-m-d');
                $data[$dateString] = $lineChartData[$i]["number"];
            }
            else{
                $data[$lineChartData[$i][$colonne]] = $lineChartData[$i]["number"];      
            }
        }   
        $visitors->generateJSONFile($data, $json, $colonne);
    }
}
