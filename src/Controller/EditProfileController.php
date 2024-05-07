<?php

namespace App\Controller;

use App\Form\EditType;
use Doctrine\ORM\EntityManagerInterface;
//use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class EditProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    #[Route('/edit/profile', name: 'app_edit_profile')]
    public function index(SessionInterface $session,Request $request): Response
    {
        $user = $session->get('user');

        $form=$this->createForm(EditType::class,$user,[
            'method'=>'POST',
            'user'=>$user
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user=$form->getData();

            // update the user
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // add a flash message for success
            $this->addFlash('success', 'Your profile has been updated.');

            return $this->redirectToRoute('/dashboard');
        }

        return $this->render('edit_profile/edit.html.twig', [
            'form' => $form->createView(),
            'user'=>$user
        ]);
//        return $this->render('edit.html.twig', [
//            'controller_name' => 'EditProfileController',
//        ]);
    }
}
