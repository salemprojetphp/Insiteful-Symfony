<?php

namespace App\Controller;
use App\Entity\Post;
use App\Entity\Like;
use App\Entity\Users;

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
        $postsPerPage = 5;
        $currentPage = max(1, $page);
        $offset = ($currentPage - 1) * $postsPerPage;

        //apply filter
        switch ($filter) {
            case 'recent':
                $postsQuery = $this->entityManager->getRepository(Post::class)
                    ->createQueryBuilder('p')
                    ->orderBy('p.date', 'DESC');
                break;
            case 'old':
                $postsQuery = $this->entityManager->getRepository(Post::class)
                    ->createQueryBuilder('p')
                    ->orderBy('p.date', 'ASC');
                break;
                case 'popular':
                    $postsQuery = $this->entityManager->getRepository(Post::class)
                        ->createQueryBuilder('p')
                        ->select('p, COUNT(l.id) + COUNT(c.id) AS activity')
                        ->leftJoin('p.likes', 'l')
                        ->leftJoin('p.comments', 'c')
                        ->groupBy('p')
                        ->orderBy('activity', 'DESC');
                    break;                
        }

        // Apply pagination
        $totalPosts = count($postsQuery->getQuery()->getResult());
        $totalPages = ceil($totalPosts / $postsPerPage);
        $postsQuery->setFirstResult($offset)
        ->setMaxResults($postsPerPage);
        $posts = $postsQuery->getQuery()->getResult();
        if($filter == 'popular'){
            $filteredPosts = [];
            foreach ($posts as $post) {
                $filteredPosts[] = $post[0];
            }
            $posts = $filteredPosts;
        }
        // dd($posts);
        //getting the liked posts
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
            'totalPages' => $totalPages,     
        ]);
    }


}
