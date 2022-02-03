<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\EditorUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/editor/user')]
class EditorUserController extends AbstractController{

    #[Route('/', name: 'editor_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository) : Response
    {
        return $this->render('edit/editor_user/index.html.twig', [
            'user' => $userRepository->findAll(),
        ]);

    }

    #[Route("/{id}", name: "editor_user_show", methods: ['GET'])]
    public function show(User $user): Response{

        return $this->render('edit/editor_user/show.html.twig', [
            'user' =>$user,

        ]);
    }

    #[Route('/{id}/delete', name: 'editor_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, UserRepository $userRepository, int $id): Response
    {

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('editor_user_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{id}/edit', name: 'editor_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditorUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('editor_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('edit/editor_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}