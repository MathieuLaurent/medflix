<?php

namespace App\Controller;

use App\Entity\Media;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class ListExploController extends AbstractController
{
    #[Route('/list/explo/{id}', name: 'list_explo')]
    public function index(ManagerRegistry $doctrine, $id): Response
    {

        $img = $doctrine
            ->getRepository(Media::Class)
            ->findBy(['category_id'=>$id]);

            

        return $this->render('list_explo/index.html.twig', [
            'img' => $img,
        ]);
    }

}
