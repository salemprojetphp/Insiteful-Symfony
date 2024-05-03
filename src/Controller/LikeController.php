<?php

namespace App\Controller;
use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LikeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/post/like/{postId}', name: 'like_toggle', methods: ['POST'])]
    public function toggleLike(SessionInterface $session,int $postId): Response
    {
        $user = $session->get('user');
        $post = $this->entityManager()->getRepository(Post::class)->find($postId);

        //if user has liked the post
        $like = $this->entityManager()->getRepository(Like::class)->findOneBy([
            'post_id' => $post,
            'user_id' => $user,
        ]);

        if ($like) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($like);
            $entityManager->flush();
        } 

        //if user hasnt liked
        else {
            // User has not liked the post, so add a like
            $like = new Like();
            $like->setPostId($post);
            $like->setUserId($user);;
            $this->entityManager->persist($like);
            $this->entityManager->flush();
        }
    }
}
