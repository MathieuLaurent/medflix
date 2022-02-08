<?php
namespace App\Service;

use App\Form\SearchNavType;
use App\Repository\MediaRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
 
class API{

    private $client;

    public function __construct(HttpClientInterface $client){
        $this->client = $client;
    }

    public function recherche(Request $request, MediaRepository $media, CategoryRepository $category): Response
    {
        $var = $request->query->all();
        $result = $var['search_nav']['name'];
        
        if(!empty($result)){
            $list = $media->searchNav($result);
        }

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
            'categorys' => $category->findByParentField(NULL),
    ]);

    }
}