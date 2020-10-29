<?php

namespace App\Controller;

use App\Controller\NewsController;
use Symfony\Component\Routing\Annotation\Route;

class TungdNewsController extends NewsController
{
    const CALENDAR_PATH = "tungd_all_news";

    public function __construct()
    {
        parent::__construct( "/bundles/OrgNews/Tungd/", "/css/tungd/", "/js/tungd/" );
    }
    /**
     * @Route("/tungd_news/view/{id}", name="tungd_news_show", methods={"GET"})
     */
    public function show( int $id )
    {
      $options = [
        'digest_count' => self :: DIGEST_COUNT,
        'id' => $id,
        'calendar_path' => self :: CALENDAR_PATH,
      ];
      return $this -> newsShow( $options );
    }

    /**
     * @Route("/tungd_news/{year}/{month}/{day}", name="tungd_all_news")
     */
    public function index( $year = 0, $month = 0, $day = 0 )
    {
        $options = [
          "calendar_path" => self :: CALENDAR_PATH,
          "news_count" => self :: NEWS_COUNT, // newsCount
          "year" => $year,
          "month" => $month,
          "day" => $day,
          ];
        return $this -> newsByDate( $options );
    }
}
