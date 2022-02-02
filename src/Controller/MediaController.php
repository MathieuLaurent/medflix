<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MediaController extends AbstractController
{
    

// /!\ PAS FINI
    #[Route("/files", name:"files")]
    public function files(MediaRepository $media) : Response
    {    

        return $this->render('pages/files.html.twig', [
            'media' =>$media->findAll()
        ]);
        // Obj -> methode;


    }
}  