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
}