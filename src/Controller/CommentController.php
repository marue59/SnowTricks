<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{

    /**
     * @Route("/new/{id}", name="comment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Trick $trick): Response
    {
        $comment = new Comment();
        //action pour rajouter l'url sur le form
        $form = $this->createForm(CommentType::class, $comment, ['action'=>$this->generateUrl('comment_new',['id'=>$trick->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTrick($trick);
            //appeler user
            $comment->setUser($this->getUser());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('trick_show', ['slug'=>$trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/_form.html.twig', [
            'form' => $form,
        ]);
    }
}
