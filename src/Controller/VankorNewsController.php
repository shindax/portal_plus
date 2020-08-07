<?php

namespace App\Controller;

use App\Entity\RnComments;
use App\Entity\RnContent;
use App\Entity\RnPhotos;
use App\Repository\RnCommentsRepository;

use App\Controller\NewsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class VankorNewsController extends NewsController
{
    const CATALOG_SECTION_ID = 26;

    public function __construct($templates_path = "/bundles/OrgNews/Vankor", $css_path = "/css/vankor/portal", $js_path = "/js/vankor/")
    {
        $this -> templates_path = $templates_path;
        $this -> css_path = $css_path;
        $this -> js_path = $js_path;
    }
    /**
     * @Route("/vankor_news", name="vankor_all_news", methods={"GET"})     */
    public function index(): Response
    {
        return $this -> news_index( self :: CATALOG_SECTION_ID, "/index.html.twig", $this -> templates_path, 11, 10 );
    }

    /**
     * @Route("/vankor_news/archive/{year}/{month}/{day}", name="vankor_news_archive", methods={"GET"})
     */
    public function archive( $year = 0, $month = 0, $day = 0 ): Response
    {
        return $this -> newsByDate(
            self :: CATALOG_SECTION_ID,
            "/archive.html.twig",
            $this -> templates_path,
            $this -> css_path,
            $this -> js_path,
            "", // переход с календаря для ВСНК

            0, // newsCount
            0, // lastNewsCount

            $year,
            $month,
            $day
        );
    }

    /**
     * @Route("/vankor_news/view/{id}", name="vankor_news_show", methods={"GET"})
     */
    public function show( int $id ): Response
    {
        return $this -> news_show(
            "/view.html.twig",
            $this -> templates_path,
            self :: CATALOG_SECTION_ID,
            11, // total news count
            3, // last news count
            $this -> css_path,
            $this -> js_path,
            0,
            0,
            $id );
    }

    /**
     * @Route("/ajax_add_comment", name="ajax_add_comment", methods={"POST"})
    */
    public function addComment( Request $request, RouterInterface $router ): Response
    {
        return $this -> newsAddComment( $request, $router );
    }
}
