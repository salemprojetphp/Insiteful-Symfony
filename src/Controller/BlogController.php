<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog/{page}/{filter}', name: 'app_blog')]
    public function index($page,$filter): Response
    {
        return $this->render('blog/blog.html.twig', [
            'currentPage' => $page,
            'currentFilter' => $filter,
        ]);
    }
}
