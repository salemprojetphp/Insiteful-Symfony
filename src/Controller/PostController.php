<?php

namespace App\Controller;
use App\Entity\Post;
use App\Form\PostType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/blog.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/addPost', name: 'app_post_add')]
    public function addPost(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        // $entityManager->persist($post);
        // $entityManager->flush();

        //return to the blog page 
        return $this->render('blog/addPost.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
