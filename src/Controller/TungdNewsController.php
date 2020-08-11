<?php

namespace App\Controller;

use App\Controller\NewsController;
use Symfony\Component\Routing\Annotation\Route;

class TungdNewsController extends NewsController
{
    const CATALOG_SECTION_ID = 26;

    public function __construct()
    {
        parent::__construct( "/bundles/OrgNews/Tungd/", "/css/tungd/", "/js/tungd/", self:: CATALOG_SECTION_ID );
    }
    /**
     * @Route("/tungd_news/view/{id}", name="tungd_news_show", methods={"GET"})
     */
    public function show( int $id )
    {
      $options = [
        'template' => "/view.html.twig",
        'digest_count' => 10,
        'id' => $id,
        'calendar_path' => 'tungd_all_news'
      ];
      return $this -> newsShow( $options );
    }

    /**
     * @Route("/tungd_news/{year}/{month}/{day}", name="tungd_all_news")
     */
    public function index( $year = 0, $month = 0, $day = 0 )
    {
        $options = [
          "template" => "list.html.twig",
          "calendar_path" => "vsnk_all_news",
          "news_count" => 11, // newsCount
          "last_news_count" => 5,  // lastNewsCount
          "year" => $year,
          "month" => $month,
          "day" => $day,
          ];

        return $this -> newsByDate( $options );
    }
}
