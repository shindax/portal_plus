<?php

namespace App\Controller;

use Sibintek\NewsBundle\Entity\OrgNews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;

class RNNewsController extends AbstractController
{
    /**
     * @Route("/rnnews", name="rnnews_index", methods={"GET"})
     */
    public function index(): Response
    {
        $news = $this->getDoctrine()
            ->getRepository(OrgNews::class)
            ->findAll();

        return $this->render('/bundles/OrgNews/index.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/rnnews/{id}", name="rnnews_show", methods={"GET"})
     */
    public function show( int $id ): Response
    {
    	$news = $this->getDoctrine()
            ->getRepository(OrgNews::class)
            ->find( $id );

        return $this->render('/bundles/OrgNews/index.html.twig', [
            'news' => $news,
        ]);
    }
}
