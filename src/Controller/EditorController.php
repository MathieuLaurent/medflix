<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorController extends AbstractController
{
    #[Route('/editor', name: 'editor')]
    public function index(): Response
    {
        return $this->render('edit/bo.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
