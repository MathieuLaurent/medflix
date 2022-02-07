<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class MediaController extends AbstractController
{
    
    #[Route("/files", name:"files")]
    public function files(MediaRepository $media, CategoryRepository $category) : Response
    {    

        $list = $media->findBy([], array('name' => 'ASC'), 20, 0);
        

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
 

        return $this->render('pages/files.html.twig', [
            'img' => $img,
            'pdf' => $pdf,
            'video' => $video,
            'categorys' => $category->findByParentField(NULL)
        ]);

    }
}  