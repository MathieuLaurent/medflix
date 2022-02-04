<?php

namespace App\Controller;

use App\Entity\Media;
use App\Repository\MediaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class ListExploController extends AbstractController
{
    #[Route('/list/explo/{id}', name: 'list_explo')]
    public function listExlo(int $id, MediaRepository $mediaRepository): Response
    {
        $list = $mediaRepository->findByCategoryField($id);
        

        foreach($list as $item){
            if($item->getExtension() == "jpg" || $item->getExtension() == "png" || $item->getExtension() == "jpeg" || $item->getExtension() == "gif"){
                $img[] = $item;
            }
            elseif($item->getExtension() == "pdf"){
                $pdf[] = $item;
            }
            elseif($item->getExtension() == "mp4" ||$item->getExtension() == "avi" ||$item->getExtension() == "webm"){
                $video[] = $item;
            }
         
        }
        if(empty($img)){
            $img = null;
        }
        if(empty($pdf)){
            $pdf = null;
        }
        if(empty($video)){
            $video = null;
        }


        return $this->render('pages/listExplo.html.twig', [
            'img' => $img,
            'pdf' => $pdf,
            'video' => $video
        ]);
    }

}
