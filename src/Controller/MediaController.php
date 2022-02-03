<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class MediaController extends AbstractController
{
    
    #[Route("/files", name:"files")]
    public function files(MediaRepository $media) : Response
    {    

        // Form preremplit 


        return $this->render('pages/files.html.twig', [
            'media' =>$media->findBy([], array('name' => 'ASC'), 20, 0),
        ]);

    }
}  