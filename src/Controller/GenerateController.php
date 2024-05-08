<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class GenerateController extends AbstractController
{
    #[Route('/generate', name: 'app_generate')]
    public function index(): Response
    {
        return $this->render('generate/index.html.twig', [
            'controller_name' => 'GenerateController',
        ]);
    }

    #[Route("/generate/action", name:"generate_pdf", methods:"GET")]
    public function generatePdf(): Response
    {
        $dompdf = new Dompdf();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);

        $html = $this->renderView('generate/pdf_template.html.twig', [
            // variables go here
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
