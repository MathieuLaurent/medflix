<?php

namespace App\Controller;

use App\Entity\Media;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class ListExploController extends AbstractController
{
    #[Route('/list/{id}', name: 'list_explo')]
    public function listExplo(int $id, MediaRepository $mediaRepository, CategoryRepository $category): Response
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

        return $this->render('pages/files.html.twig', [
            'img' => $img,
            'pdf' => $pdf,
            'video' => $video,
            'category' => $category->find($id),
            'categorys' => $category->findByParentField(NULL)
        ]);
    }

    public function renderCategory(CategoryRepository $category, int $catId){

        return $this->render('inc/_category.html.twig', [
            'categorys' => $category->findByParentField($catId)
        ]);
    }

}
