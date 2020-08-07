<?php

namespace App\Controller;

use App\Entity\RnContent;
use App\Entity\RnPhotos;
use App\Entity\RnComments;
use App\Repository\RnCommentsRepository;

use App\Controller\NewsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class VsnkNewsController extends NewsController
{
    const CATALOG_SECTION_ID = 26;

    public function __construct( $templates_path = "/bundles/OrgNews/VSNK", $css_path = "/css/vsnk/portal", $js_path = "/js/vsnk/" )
    {
        $this -> templates_path = $templates_path;
        $this -> css_path = $css_path;
        $this -> js_path = $js_path;
    }
    /**
     * @Route("/vsnk_news/view/{id}", name="vsnk_news_show", methods={"GET"})
     */
    public function show( int $id ): Response
    {
      return $this -> news_show(
        "/view.html.twig",
        $this -> templates_path,
        self :: CATALOG_SECTION_ID,
        0, // total news count
        0, // last news count
        $this -> css_path,
        $this -> js_path,
        0,
        10,
        $id );
    }

    /**
     * @Route("/vsnk_news/{year}/{month}/{day}", name="vsnk_all_news")
     */
    public function index( $year = 0, $month = 0, $day = 0 ): Response
    {
        return $this -> newsByDate(
          self :: CATALOG_SECTION_ID,
          "/list.html.twig",
          $this -> templates_path,
          $this -> css_path,
          $this -> js_path,
          'vsnk_all_news',  // переход с календаря
          11,
          5,
          $year,
          $month,
          $day,
        );
    }
}
