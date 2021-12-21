<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Video;
use DateTimeImmutable;
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
use Symfony\Component\HttpFoundation\File\Exception\FileException;


/**
 * @Route("/trick")
 */
class TrickController extends AbstractController
{
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

            $this->handleVideos($form->get('video'));

             // $picture = PictureType
            foreach ($form->get('picture') as $picture ) {
                // $model = Picture
                $model = $picture->getData();
                // $picturFile = UploadFile // upload fait automatiquement grace au FileType
                $pictureFile = $picture->get('path')->getData();
    
                if ($pictureFile) {
                    $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();
    
                    try{
                        $pictureFile->move(
                            $this->getParameter('kernel.project_dir') . '/public/images/picture_upload/',
                            $newFilename
                        );
                        $model->setPath($newFilename);
    
                    } catch (FileExeption $e) {
                
                        $this->addFlash('danger', "Nous avons rencontrés un probleme");
                    }  
                }
            }
            //ajouter slug.
            $trick->setSlug($slugger->slug($trick->getName()));

        
            $entityManager->persist($trick);
            $entityManager->flush();
            
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        
        }
       
        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form
        ]);   
    
    }

    /**
     * @Route("/{slug}", name="trick_show", methods={"GET"})
     */
    public function show(Trick $trick): Response
    {
        
        return $this->render('trick/show.html.twig', [
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="trick_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //utilisation de la methode video
            $this->handleVideos($form->get('video'));
            $entityManager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }
    //methode pour prendre l'id de la video aprés le / et le stocker en bdd
    public function handleVideos($videos) 
    {
        foreach ($videos as $key => $video) {
            $model = $video->getData();
            $link = $video->get('url')->getData();
            $newLink = \substr($link, \strrpos($link, "/") + 1);
            $model->setUrl($newLink);
         }
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

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
