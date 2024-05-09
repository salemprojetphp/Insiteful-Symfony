<?php

namespace App\Controller;

use App\Entity\Feedbacks;
use App\Repository\FeedbacksRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/admin', name: 'app_admin')]
class AdminController extends AbstractController
{
    #[Route('/')]
    public function index(UserRepository $user, SessionInterface $session): Response
    {
        if($session->get('user')->getRole() == "User"){
            $exception = ["message" => "Access denied"];
            return $this->render('error.html.twig', [
                'exception' => $exception
            ]);
        }
        $users = $user->getUsersAndTheirIds();
        return $this->render('admin/adminDashboard.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users
        ]);
    }
    
    #[Route('/feedbacks', name:'feedbacks')]
    public function adminFeedback(FeedbacksRepository $feedback, SessionInterface $session) : Response{

        if($session->get('user')->getRole() == "User"){
            $exception = ["message" => "Access denied"];
            return $this->render('error.html.twig', [
                'exception' => $exception
            ]);
        }
        $feedbacks = $feedback->findAll();
        return $this->render('admin/adminFeedbacks.html.twig',[
            'feedbacks' => $feedbacks
        ]);
    }
    #[Route('/delete/{id}')]
    public function deleteFeedback(Feedbacks $feedback=null, ManagerRegistry $doctrine): RedirectResponse {
        if($feedback){
            $manager = $doctrine->getManager();
            $manager->remove($feedback);
            $manager->flush();
        }
        return $this->redirect('/admin/feedbacks');

    }
}
