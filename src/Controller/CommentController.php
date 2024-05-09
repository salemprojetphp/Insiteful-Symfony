<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Post;
use App\Entity\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class CommentController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/add/comment/{id}/{content}', name: 'app_comment')]
    public function index(SessionInterface $session,Request $request, $id, $content): Response
    {
        $comment = new Comment();
        $comment->setDateSince((new \DateTime())->format('d F Y H:i:s'));
        $comment->setPostId($this->entityManager->getRepository(Post::class)->find($id));
        $comment->setUserId($this->entityManager->getRepository(Users::class)->find($session->get('user')->getId()));
        $comment->setContent($content);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();  
        return new Response('Comment added');
    }

    #[Route('/commentId', name: 'get_max_comment_id')]
    public function getMaxCommentId(): JsonResponse
    {
        $maxId = $this->entityManager->createQueryBuilder()
            ->select('MAX(c.id)')
            ->from('App\Entity\Comment', 'c')
            ->getQuery()
            ->getSingleScalarResult();

        return new JsonResponse(['max_id' => $maxId]);
    }

    #[Route('/delete/comment/{id}', name: 'delete_comment')]
    public function deleteComment($id): Response
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        return new Response('Comment deleted');
    }

    #[Route('/edit/comment/{id}/{content}', name: 'edit_comment')]
    public function editComment($id, $content): Response
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        $comment->setContent($content);
        $this->entityManager->flush();
        return new Response('Comment edited');
    }

}
