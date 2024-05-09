<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('registration/register.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Request $request, $response,SessionInterface $session): void
    {

// Invalidate the session
        $session->invalidate();
        $response->headers->clearCookie('PHPSESSID');

// Optionally, set the cookie with an expiration date in the past to ensure it's deleted
        $response->headers->setCookie(Cookie::create('your_cookie_name')
            ->withValue('')
            ->withExpires(new \DateTime('yesterday'))
            ->withPath('/')
        );

// Send the response to the client
        $response->send();

// Optionally, regenerate the session ID
        $session->migrate(true);
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
