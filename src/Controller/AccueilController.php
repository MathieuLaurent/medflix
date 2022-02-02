<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('pages/accueil.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

// /!\ PAS FINI
    #[Route("/pdf", name:"file_pdf")]
    public function pdfFiles() : Response
    {



        return $this->render("pages/pdfFiles.html.twig", [

        ]);

    }

}
