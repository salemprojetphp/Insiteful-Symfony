<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'app_admin')]
class AdminController extends AbstractController
{
    #[Route('/')]
    public function index(UserRepository $user): Response
    {
        $users = $user->getUsersAndTheirIds();
        return $this->render('admin/adminDashboard.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users
        ]);
    }
}
