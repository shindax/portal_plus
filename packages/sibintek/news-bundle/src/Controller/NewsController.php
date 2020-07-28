<?php

namespace Sibintek\NewsBundle\Controller;

use Sibintek\NewsBundle\Entity\OrgNews;
// use Sibintek\NewsBundle\Repository\OrgNewsRepository;
// use Sibintek\NewsBundle\Form\WeatherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news_index", methods={"GET"})
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
     * @Route("/news/{id}", name="news_show", methods={"GET"})
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
