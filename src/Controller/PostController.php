<?php

namespace App\Controller;

use App\Form\PostType;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Like;
use App\Entity\Comment;
use App\Form\CommentType;
use DateTime;
use DateTimeZone;

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
    #[Route('/post/{id}/comments', name: 'app_post_comms')]
    public function index(SessionInterface $session, Request $request, $id): Response
    {
        $user = $session->get('user');
        $postId = (int)$id;
        
        // Fetch the post
        $post = $this->entityManager->getRepository(Post::class)->find($postId);
        
        // Check if the user has liked the post
        $liked = $this->entityManager->getRepository(Like::class)->findOneBy([
            'post_id' => $post,
            'user_id' => $user,
        ]) !== null;
        
        // Fetch comments for the post
        $comments = $this->entityManager->getRepository(Comment::class)->findBy(['post_id' => $post]);
        foreach ($comments as $comment) {
            $comment->timeDiff = $this->calculateTimeDiff(new \DateTime($comment->getDateSince()));
        }

        return $this->render('post/post.html.twig', [
            'post' => $post,
            'liked' => $liked,
            'comments' => $comments,
        ]);
    }

    private function calculateTimeDiff(DateTime $commentDate): string
    {
        // Set the timezone of the comment date to the server's timezone
        $commentDate->setTimezone(new DateTimeZone(date_default_timezone_get()));

        // Get the current date and time in the server's timezone
        $currentDate = new DateTime('now', new DateTimeZone(date_default_timezone_get()));

        // Calculate the difference between the current date and the comment date
        $interval = $currentDate->diff($commentDate);

        // Format the time difference
        $format = '';
        if ($interval->y > 0) {
            if ($interval->y === 1) {
                $format = '%y year';
            } else {
                $format = '%y years';
            }
        } elseif ($interval->m > 0) {
            if ($interval->m === 1) {
                $format = '%m month';
            } else {
                $format = '%m months';
            }
        } elseif ($interval->d > 0) {
            if ($interval->d === 1) {
                $format = '%d day';
            } else {
                $format = '%d days';
            }
        } elseif ($interval->h > 0) {
            if ($interval->h === 1) {
                $format = '%h hour';
            } else {
                $format = '%h hours';
            }
        } elseif ($interval->i > 0) {
            if ($interval->i === 1) {
                $format = '%i minute';
            } else {
                $format = '%i minutes';
            }
        } else {
            return'Just Now';
        }

        return $interval->format($format . ' ago');
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
