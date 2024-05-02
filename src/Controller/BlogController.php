<?php

namespace App\Controller;
use App\Entity\Post;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class BlogController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/blog/{page}/{filter}', name: 'app_blog')]
    public function index($page,$filter): Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        return $this->render('blog/blog.html.twig', [
            'currentPage' => $page,
            'currentFilter' => $filter,
            'posts' => $posts,
        ]);
    }


}
