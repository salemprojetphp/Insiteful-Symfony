<?php

namespace App\Controller;

use App\Entity\Feedbacks;
use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class FeedbacksController extends AbstractController
{
    private $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/feedbacks/add', name: 'feedbacks_add', methods: ['POST'])]
    public function addFeedback(SessionInterface $session,ManagerRegistry $doctrine,Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $feedback = new Feedbacks();
        $entityManager = $doctrine->getManager();
        $feedback->setHidden(0);
        $feedback->setDate(new \DateTime());
        $user = $this->entityManager->getRepository(Users::class)->find($session->get('user'));
        $feedback->setUserid($user);
        $feedback->setFeedback($data['feedback']);
        $entityManager->persist($feedback);
        $entityManager->flush();
        return new Response('ok');
    }
}
