<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MediaRepository;

class MediaController extends AbstractController
{
    

// /!\ PAS FINI
    #[Route("/files", name:"files")]
    public function files(MediaRepository $media) : Response
    {    

        return $this->render('pages/files.html.twig', [
            //findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
            //$service = $repository->findBy(array('name' => 'Registration'),array('name' => 'ASC'),1 ,0)[0];
            'media' =>$media->findBy([], array('name' => 'ASC'), 20, 0),
            "test" => "karibou"
        ]);

    }
}  