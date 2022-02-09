<?php

namespace App\Controller;

use App\Form\FiltreType;
use App\Repository\MediaRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/profile')]
class FiltreController extends AbstractController
{

    
    #[Route('/filtre', name: 'filtre', methods:['GET'])]
    public function filtre(CategoryRepository $category, Request $request, MediaRepository $media): Response
    {

        
        $var = $request->query->all();
        $ordreTri = $var['filtre']['createdAt'];
        if(!empty($var['filtre']['extension'])){
            $extension = $var['filtre']['extension'];
        }
        
        if(!empty($ordreTri) && $ordreTri ==  'date'){
            $result  = "createdAt";
        }
        elseif(!empty($ordreTri) && $ordreTri == 'nom'){
            $result = "name";
        }

        if(!empty($extension)){
            $list = $media->findExtension($extension, $result);
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
            'categorys' => $category->findByParentField(NULL),
        ]);
    }


    public function renderFiltre(Request $request){

        $formFiltre = $this->createForm(FiltreType::class);
        $formFiltre->handleRequest($request);

        if($formFiltre->isSubmitted() && $formFiltre->isValid()){
            
            return $this->redirectToRoute('filtre', [
                'formData' => $formFiltre->getData(),
            ]);
        }

        return $this->render('inc/_filtres.html.twig', [
            'formFiltre' => $formFiltre->createView()
        ]);
    }
}
