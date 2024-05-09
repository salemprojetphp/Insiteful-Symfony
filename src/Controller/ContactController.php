<?php

namespace App\Controller;

use App\Service\MailerService; // Import the MailerService namespace
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods:'POST')]
    public function index(Request $request, MailerService $mailer): Response
    {
        $data = json_decode($request->getContent(), true);        
        $mailer.receiveMail($data['email'], $data['object'], $data['message']);
        
        return new Response('Email sent successfully', Response::HTTP_OK);
    }
}
