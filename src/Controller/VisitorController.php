<?php

namespace App\Controller;

use App\Entity\Visitors;
use App\Entity\Users;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;


class VisitorController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register/visitor', name: 'app_visitor')]
    public function index(Request $request): Response
    {
        $visitor = new Visitors();
        $requestData = json_decode($request->getContent(), true);

        $visitor->setWebsite($requestData['website'] ?? null);
        $visitor->setIp($requestData['ip'] ?? null);
        $visitor->setDate(new \DateTime('now'));
        $visitor->setReferrer($requestData['referrer'] ?? "direct");
        $visitor->setCountry($requestData['country'] ?? null);
        $visitor->setDevice($requestData['device'] ?? null);
        $visitor->setBrowser($requestData['browser'] ?? null);

        //fetch the owner of the website 
        $website = $this->entityManager->getRepository('App\Entity\Websites')->findOneBy(['url' => $visitor->getWebsite()]);
        $visitor->setUserId($website->getOwner()->getId());

        $this->entityManager->persist($visitor);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Visitor registered successfully'], Response::HTTP_CREATED);
    }
}
