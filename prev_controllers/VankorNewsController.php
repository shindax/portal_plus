<?php
namespace App\Controller;

use App\Controller\NewsController;
use Symfony\Component\Routing\Annotation\Route;

class VankorNewsController extends NewsController
{
    const LAST_NEWS_COUNT_IN_SHOW = 3;
    const COMMENTS_COUNT = 10;

    public function __construct()
    {
        parent::__construct( "/bundles/OrgNews/Vankor/", "/css/vankor", "/js/vankor/" );
    }
    /**
     * @Route("/vankor_news", name="vankor_all_news", methods={"GET"})     */
    public function index()
    {
        $options = [
            "news_count" => self :: NEWS_COUNT,
            "comments_count" => self :: COMMENTS_COUNT ,
        ];
        return $this -> newsIndex( $options );
    }

    /**
     * @Route("/vankor_news/archive/{year}/{month}/{day}", name="vankor_news_archive", methods={"GET"})
     */
    public function archive( $year = 0, $month = 0, $day = 0 )
    {
        $options = [
          "year" => $year,
          "month" => $month,
          "day" => $day,
          ];
        return $this -> newsByDate( $options );
    }

    /**
     * @Route("/vankor_news/view/{id}", name="vankor_news_show", methods={"GET"})
     */
    public function show( int $id )
    {
      $options = [
        'news_count' => self :: NEWS_COUNT,
        'last_news_count' => self :: LAST_NEWS_COUNT_IN_SHOW,
        'id' => $id,
      ];
      return $this -> newsShow( $options );
    }
}
