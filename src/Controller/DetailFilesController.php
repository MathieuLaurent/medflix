<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\MediaRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class DetailFilesController extends AbstractController
{

    #[Route('/detail/files/{id}', name: 'detail_files')]
    public function displayDetail(MediaRepository $mediaRepository, int $id, CategoryRepository $category): Response
    {
        $item= $mediaRepository
        ->find($id);

        if($item->getExtension() == "jpg" || $item->getExtension() == "png" || $item->getExtension() == "jpeg" || $item->getExtension() == "gif"){
            $img = $item;
        }
        elseif($item->getExtension() == "pdf"){
            $pdf = $item;
        }
        elseif($item->getExtension() == "mp4" ||$item->getExtension() == "avi" ||$item->getExtension() == "webm"){
            $video= $item;
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
        return $this->render('pages/detail_files.html.twig', [
            
            'img' => $img,
            'pdf' => $pdf,
            'video' => $video,
            'categorys' => $category->findByParentField(NULL)
        ]);
    }
}
