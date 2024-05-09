<?php

namespace App\Controller;

use App\Form\EditType;
use App\Form\PasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EditProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;
//    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
//        $this->passwordHasher=$passwordHasher;
    }
    #[Route('/edit/profile', name: 'app_edit_profile')]
    public function index(SessionInterface $session,Request $request): Response
    {
        $user = $session->get('user');

        $form=$this->createForm(EditType::class,$user,[
            'method'=>'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user=$form->getData();

            // update the user
            $this->entityManager->flush();

            // add a flash message for success
            $this->addFlash('success', 'Your profile has been updated.');

            return $this->redirect('/dashboard');
        }

        return $this->render('edit_profile/edit.html.twig', [
            'form' => $form->createView(),
            'user'=>$user
        ]);
    }

//    #[Route('/edit/password', name: 'app_edit_password')]
//    public function updatePassword(SessionInterface $session, Request $request,UserPasswordHasherInterface $passwordHasher):Response
//    {
//        ini_set('memory_limit', '1024M');
//        $user = $session->get('user');
//        $form = $this->createForm(PasswordType::class, $user, [
//            'method' => 'POST'
//        ]);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $oldPassword = $form->get('oldPassword')->getData();
//
//            //Old password verification
//            if (!$passwordHasher->isPasswordValid($user,$oldPassword)) {
//                $this->addFlash('danger', 'Old password is not valid');
//            }
//            else{
//                $newPassword = $form->get('newPassword')->getData();
//                $user->setPassword($passwordHasher->hashPassword($user,$newPassword));
//                $this->entityManager->flush();
//
//                $this->addFlash('success', 'Password updated successfully');
//                return $this->redirect('/dashboard');
//            }
//        }
//        return $this->render('edit_profile/edit-password.html.twig', [
//            'form' => $form->createView(),
//            'user'=> $user
//        ]);
//    }

}
