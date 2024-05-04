<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LikeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/post/like/{postId}', name: 'like_toggle')]
    public function like(SessionInterface $session,Request $request, $postId): JsonResponse
    {
        $user = $session->get('user')->getId();
        $post = $this->entityManager->getRepository(Post::class)->find($postId);
        $like = new Like();
        $like->setPostId($post);
        $like->setUserId($this->entityManager->getRepository(User::class)->find($user));
        
        $this->entityManager->persist($like);
        $this->entityManager->flush();
        
        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/post/unlike/{postId}', name: 'unlike_toggle')]
    public function unlike(SessionInterface $session,Request $request, $postId): JsonResponse
    {
        $user = $session->get('user');
        $post = $this->entityManager->getRepository(Post::class)->find($postId);

        $like = $this->entityManager->getRepository(Like::class)->findOneBy([
            'post_id' => $post,
            'user_id' => $user
        ]);

        $this->entityManager->remove($like);
        $this->entityManager->flush();
        
        return new JsonResponse(['status' => 'ok']);
    }
}
