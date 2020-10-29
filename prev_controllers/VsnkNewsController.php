<?php

namespace App\Controller;

use App\Controller\NewsController;
use Symfony\Component\Routing\Annotation\Route;

class VsnkNewsController extends NewsController
{
    const CALENDAR_PATH = "vsnk_all_news";

    public function __construct()
    {
        parent::__construct( "/bundles/OrgNews/VSNK/", "/css/vsnk/", "/js/vsnk/");
    }
    /**
     * @Route("/vsnk_news/view/{id}", name="vsnk_news_show", methods={"GET"})
     */
    public function show( int $id )
    {
      $options = [
        'digest_count' => self :: DIGEST_COUNT,
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
          "calendar_path" => self :: CALENDAR_PATH,
          "news_count" => self :: DIGEST_COUNT,
          "year" => $year,
          "month" => $month,
          "day" => $day,
          ];
        return $this -> newsByDate( $options );

    }
}
