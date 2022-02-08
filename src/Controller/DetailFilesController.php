<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class DetailFilesController extends AbstractController
{
    #[Route('/detail/files/{id}', name: 'detail_files')]
    public function index(): Response
    {
        return $this->render('pages/detail_files.html.twig', [
            'controller_name' => 'DetailFilesController',
        ]);
    }
}
