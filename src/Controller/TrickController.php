<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Video;
use App\Entity\Picture;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/trick")
 */
class TrickController extends AbstractController
{
    /**
     * @Route("/", name="trick_index", methods={"GET"})
     */
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="trick_new", methods={"GET", "POST"})
     */
    public function new(Request $request, 
    EntityManagerInterface $entityManager, 
    SluggerInterface $slugger): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick); 
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();
dump($trick);
            foreach ($trick->getPicture() as $picture ) {

                /** @var UploadedFile $pictureFile */
                $pictureFile = $picture->getPath();
                if ($pictureFile) {
                    $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();
    
                    try{
                    $pictureFile->move(
                        $this->getParameter(('kernel.project_dir').'/public/picture_upload'),
                        $newFilename
                    );
                    } catch (FileExeption $e) {
                    
                    $this->addFlash('danger', "Nous avons rencontrés un probleme");
                    }  
                }
            }
            $trick->setPicture($newFilename);

            $entityManager->persist($trick);
            $entityManager->flush();
            
            return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
        
        }
        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form
        ]);   
    
    }

    /**
     * @Route("/{id}", name="trick_show", methods={"GET"})
     */
    public function show(Trick $trick): Response
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="trick_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="trick_delete", methods={"POST"})
     */
    public function delete(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
    }
}
