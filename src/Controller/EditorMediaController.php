<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

<<<<<<< HEAD
#[Route('/edit/media')]
=======
#[Route('/editor/media')]
>>>>>>> 2519f8b8759bc6993d1cd981b3be5573f6736107
class EditorMediaController extends AbstractController
{
    #[Route('/', name: 'edit_media_index', methods: ['GET'])]
    public function index(MediaRepository $mediaRepository): Response
    {
        return $this->render('edit/edit_media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'edit_media_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medium);
            $entityManager->flush();

            return $this->redirectToRoute('edit_media_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('edit/edit_media/new.html.twig', [
            'medium' => $medium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'edit_media_show', methods: ['GET'])]
    public function show(Media $medium): Response
    {
        return $this->render('edit/edit_media/show.html.twig', [
            'medium' => $medium,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit_media_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Media $medium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('edit_media_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('edit/edit_media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'edit_media_delete', methods: ['POST'])]
    public function delete(Request $request, Media $medium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
            $entityManager->remove($medium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edit_media_index', [], Response::HTTP_SEE_OTHER);
    }
}
