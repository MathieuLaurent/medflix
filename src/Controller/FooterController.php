<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Controller\EditorUserController;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

Class FooterController extends AbstractController{

    #[Route('/cgv', name: 'cgv')]
    public function CGV() : Response{

        return $this->render("pages/CGV.html.twig", []);

    }

    #[Route('/ml', name: 'ml')]
    public function ML() : Response{

        return $this->render("pages/ML.html.twig", []);

    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, ContactRepository $contactRepository,
    EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        return $this->renderForm('pages/contact.html.twig', [
                    'form' => $form,
                ]);

    
    } 


    }