<?php

namespace App\Controller;

use App\Form\PostType;
use App\Entity\Post;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class PostController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/post/{id}', name: 'app_post')]
    public function index($id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);
        return $this->render('post/post.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/addPost', name: 'app_post_add')]
    public function addPost(SessionInterface $session,Request $request): Response
    {
        $post = new Post();
        $post->setDate(new \DateTime());

        $userRepository = $this->entityManager->getRepository(User::class);
        $authorID = $session->get('user')->getId();
        $author = $userRepository->find($authorID);
        $post->setAuthor($author);

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            
            if ($imageFile) {
                $imageData = file_get_contents($imageFile->getPathname());
                $post->setImage($imageData);
                $extension = $imageFile->guessExtension();
                $post->setImageFormat($extension);
            }

            $this->entityManager->persist($post);
            $this->entityManager->flush();  
            
            return $this->redirectToRoute('app_blog', [
                'page' => 1, 
                'filter' => 'recent', 
            ]);
        }
        
        // Render the form template
        return $this->render('blog/addPost.html.twig', [
            'form' => $form->createView(),
            'action' => 'add',
            'image' => null,
        ]);
    }

    #[Route('/deletePost/{id}', name: 'app_delete_post')]
    public function deletePost($id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_blog', [
            'page' => 1, 
            'filter' => 'recent', 
        ]);
    }

    #[Route('/editPost/{id}', name: 'app_edit_post')]
    public function editPost(Request $request,$id) : Response
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);
        $originalImage = $post->getOriginalImageData();
        $image = ($post->getImage());
        $form = $this->createForm(PostType::class, $post);  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageData = file_get_contents($imageFile->getPathname());
                $post->setImage($imageData);
                $extension = $imageFile->guessExtension();
                $post->setImageFormat($extension);
            } else {
                $post->setImage($originalImage);
            }
            $this->entityManager->flush();
            
            return $this->redirectToRoute('app_blog', [
                'page' => 1, 
                'filter' => 'recent', 
            ]);
        }

        return $this->render('blog/addPost.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'image' => $image,
            'action' => 'edit',
        ]);
    }
}
