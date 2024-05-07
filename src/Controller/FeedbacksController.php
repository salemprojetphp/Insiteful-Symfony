<?php

namespace App\Controller;

use App\Entity\Feedbacks;
use App\Form\FeedbacksType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FeedbacksController extends AbstractController
{
    #[Route('/feedbacks/add', name: 'feedbacks.add')]
    public function addFeedback(ManagerRegistry $doctrine,Request $request): Response
    {
        $feedback = new Feedbacks();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(FeedbacksType::class, $feedback);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $feedback->setDate(new \DateTime());
            $feedback->setUserid($this->getUser());
            $entityManager->persist($feedback);
            $entityManager->flush();
            return $this->redirectToRoute('feedbacks.add');
        }
        return $this->render('feedbacks/feedbacks.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
