<?php

namespace App\Controller;

use App\Form\FiltreType;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
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
        $extension = $var['filtre']['extension'];
        
        if(!empty($ordreTri) && $ordreTri ==  'date'){
            $result  = "createdAt";
        }
        elseif(!empty($ordreTri) && $ordreTri == 'nom'){
            $result = "name";
        }

        if(!empty($extension)){
            foreach($extension as $item){
                if($item == "jpg"){
                    $img[] = $media->findExtension("jpg", $result);
                }
                elseif($item == "png"){
                    $img[] = $media->findExtension('png', $result);
                }
                elseif($item == "jpeg"){
                    $img[] = $media->findExtension('jpeg', $result);
                }
                elseif($item == "gif"){
                    $img[] = $media->findExtension('gif', $result);
                }
                elseif($item == "pdf"){
                    $pdf[] = $media->findExtension('pdf', $result);
                }
                elseif($item == "webm"){
                    $video[] = $media->findExtension('webm', $result);
                }
                elseif($item == "mp4"){
                    $video[] = $media->findExtension('mp4', $result);
                }
                elseif($item == "avi"){
                    $video[] = $media->findExtension('avi', $result);
                }
                elseif($item == "img"){
                    $img[] = $media->findExtension('jpg', $result);
                    $img[] = $media->findExtension('jpeg', $result);
                    $img[] = $media->findExtension('png', $result);
                    $img[] = $media->findExtension('gif', $result);
                }
                elseif($item == "video"){
                    $video[] = $media->findExtension('webm', $result);
                    $video[] = $media->findExtension('mp4', $result);
                    $video[] = $media->findExtension('avi', $result);
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
        }
        
        return $this->render('pages/filtres.html.twig', [
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
