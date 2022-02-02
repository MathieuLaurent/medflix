<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/profile")]
class UserController extends AbstractController{

    #[Route('/{id}', name: 'user_profile', methods: ['GET', "POST"])]
    public function profile(UserRepository $userRepo) : Response
    {

        return $this->render('pages/profile.html.twig', [
            //'media' =>$media->findBy([], array('name' => 'ASC'), 20, 0),
        ]);

    }

} 