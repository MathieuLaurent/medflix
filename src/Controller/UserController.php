<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/profile")]
class UserController extends AbstractController{

    #[Route('/{id}', name: 'user_profile', methods: ['GET', "POST"])]
    public function profile(Request $request, User $user, EntityManagerInterface $entityManager) : Response
    {

        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute("files", [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/profile.html.twig', [
            'user' =>$user,
            "form" => $form->createView(),

        ]);

    }

} 