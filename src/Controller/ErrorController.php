<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class ErrorController extends AbstractController
{
    public function show(FlattenException $exception): Response
    {
        return $this->render('error.html.twig', [
            'exception' => $exception,
        ]);
    }
}