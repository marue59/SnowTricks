<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(TrickRepository $trickRepository, Request $request): Response
    {
        $page = $request->get('page', 1);

        $limit = 10;
        $tricks = $trickRepository->createQueryBuilder('t')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ->getQuery()->getResult();

        if ($request->isXmlHttpRequest()) {
            return $this->render(
                'home/_list.html.twig',
                ['tricks' => $tricks]
            );
        }


        return $this->render(
            'home/index.html.twig',
            ['tricks' => $tricks]
        );
    }
}
