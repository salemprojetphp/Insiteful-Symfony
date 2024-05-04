<?php

namespace App\Controller;
use App\Entity\Post;
use App\Entity\Like;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BlogController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/blog/{page}/{filter}', name: 'app_blog')]
    public function index(SessionInterface $session ,$page,$filter): Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        // $liked = $this->entityManager->getRepository(Like::class)->findOneBy([
        //     'post_id' => $post,
        //     'user_id' => $user,
        // ]) !== null;
        $user = $session->get('user')->getId();
        $likedPosts = $this->entityManager->getRepository(Like::class)
            ->createQueryBuilder('l')
            ->select('IDENTITY(l.post_id) AS postId')
            ->where('l.user_id = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    
        // Extract the post IDs from the array
        $likedPostIds = array_map(function($like) {
            return $like['postId'];
        }, $likedPosts);

        return $this->render('blog/blog.html.twig', [
            'currentPage' => $page,
            'currentFilter' => $filter,
            'posts' => $posts,
            'liked' => $likedPostIds,
        ]);
    }


}
