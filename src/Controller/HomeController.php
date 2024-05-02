<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SessionInterface $session): Response
    {
        $session->set('userID',null);
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
