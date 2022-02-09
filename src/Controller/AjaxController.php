<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


#[Route('profile')]
class AjaxController extends AbstractController
{

    #[Route('files')]
    public function ajaxFiltre(){

    }
}