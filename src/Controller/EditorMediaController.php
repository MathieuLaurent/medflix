<?php

namespace App\Controller;

use App\Entity\Media;
use App\Service\FileResize;
use App\Form\MediaType;
use Imagine\Gd\Imagine;
use App\Service\ImageResize;
use Gedmo\Sluggable\Util\Urlizer;
use App\Repository\UserRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/editor/media')]
class EditorMediaController extends AbstractController
{
    private $resizer;

    public function __construct()
    {
        $this->resizer = new FileResize();
    }

    #[Route('/', name: 'edit_media_index', methods: ['GET'])]
    public function index(MediaRepository $mediaRepository): Response
    {
        return $this->render('edit/edit_media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'edit_media_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {


        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $medium->setUserAuthor($user);

            $medium->setCreatedAt(new \DateTimeImmutable('now'));

            $uploadedFile = $form['link']->getData();
            
            if($uploadedFile && ($uploadedFile->guessExtension() == "jpg" || $uploadedFile->guessExtension() == "png" || $uploadedFile->guessExtension() == "jpeg" || $uploadedFile->guessExtension() == "gif")){
                $destination = $this->getParameter('kernel.project_dir').'/public/img';
                $medium->setExtension($uploadedFile->guessExtension());
                
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);
                $medium->setLink($newFilename);

                $this->resizer->resize($destination.'/'.$newFilename);
                $this->resizer->resizeInter($destination.'/'.$newFilename);

            }
            elseif($uploadedFile && ($uploadedFile->guessExtension() == "pdf")){
                $destination = $this->getParameter('kernel.project_dir').'/public/pdf';

                $medium->setExtension($uploadedFile->guessExtension());
                
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);
                $medium->setLink($newFilename);
            }
            elseif($uploadedFile && ($uploadedFile->guessExtension() == "avi" || $uploadedFile->guessExtension() == "webm" || $uploadedFile->guessExtension() == "mp4")){
                $destination = $this->getParameter('kernel.project_dir').'/public/video';
                $medium->setExtension($uploadedFile->guessExtension());
                
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);
                $medium->setLink($newFilename);
            }
            

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
    public function edit(Request $request, Media $medium, EntityManagerInterface $entityManager, int $id, MediaRepository $mediaRepository): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['link']->getData();
            
            $edit = $mediaRepository->find($id);
            $lien = $edit-> getLink();
            $extension = $edit->getExtension();
            if(!empty($lien)){
                if($extension == "jpg" || $extension == "png" || $extension =="jpeg" || $extension == "gif"){
                    unlink($this->getParameter('kernel.project_dir').'/public/img/'.$lien);
                    unlink($this->getParameter('kernel.project_dir').'/public/imgMiniature/'.$lien);
                    unlink($this->getParameter('kernel.project_dir').'/public/imgInter/'.$lien);
                }
                elseif($extension == "pdf"){
                    unlink($this->getParameter('kernel.project_dir').'/public/pdf/'.$lien);
                }
                elseif($extension == "mp4" || $extension == "webm" || $extension == "avi"){
                    unlink($this->getParameter('kernel.project_dir').'/public/video/'.$lien);
                }
            
            $medium->setLink(''); 
            $medium->setExtension('');
            $entityManager->flush();
            }
            if($uploadedFile && ($uploadedFile->guessExtension() == "jpg" || $uploadedFile->guessExtension() == "png" || $uploadedFile->guessExtension() == "jpeg" || $uploadedFile->guessExtension() == "gif")){
                $destination = $this->getParameter('kernel.project_dir').'/public/img';
                $medium->setExtension($uploadedFile->guessExtension());
                
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);
                $medium->setLink($newFilename);

                $this->resizer->resize($destination.'/'.$newFilename);
                $this->resizer->resizeInter($destination.'/'.$newFilename);

            }
            elseif($uploadedFile && ($uploadedFile->guessExtension() == "pdf")){
                $destination = $this->getParameter('kernel.project_dir').'/public/pdf';

                $medium->setExtension($uploadedFile->guessExtension());
                
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);
                $medium->setLink($newFilename);
            }
            elseif($uploadedFile && ($uploadedFile->guessExtension() == "avi" || $uploadedFile->guessExtension() == "webm" || $uploadedFile->guessExtension() == "mp4")){
                $destination = $this->getParameter('kernel.project_dir').'/public/video';
                $medium->setExtension($uploadedFile->guessExtension());
                
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);
                $medium->setLink($newFilename);
            }

            $entityManager->persist($medium);
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
