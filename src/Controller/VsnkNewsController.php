<?php

namespace App\Controller;

use App\Controller\NewsController;
use Symfony\Component\Routing\Annotation\Route;

class VsnkNewsController extends NewsController
{
    const CATALOG_SECTION_ID = 26;

    public function __construct()
    {
        parent::__construct( "/bundles/OrgNews/VSNK/", "/css/vsnk/", "/js/vsnk/", self:: CATALOG_SECTION_ID );
    }
    /**
     * @Route("/vsnk_news/view/{id}", name="vsnk_news_show", methods={"GET"})
     */
    public function show( int $id )
    {
      $options = [
        'template' => "/view.html.twig",
        'digest_count' => 10,
        'id' => $id,
      ];
      return $this -> newsShow( $options );
    }

    /**
     * @Route("/vsnk_news/{year}/{month}/{day}", name="vsnk_all_news")
     */
    public function index( $year = 0, $month = 0, $day = 0 )
    {
        $options = [
          "template" => "list.html.twig",
          "calendar_path" => "vsnk_all_news",
          "news_count" => 11,
          "last_news_count" => 5,
          "year" => $year,
          "month" => $month,
          "day" => $day,
          ];

        return $this -> newsByDate( $options );

    }
}
