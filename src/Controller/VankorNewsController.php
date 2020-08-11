<?php
namespace App\Controller;

use App\Controller\NewsController;
use Symfony\Component\Routing\Annotation\Route;

class VankorNewsController extends NewsController
{
    const CATALOG_SECTION_ID = 26;

    public function __construct()
    {
        parent::__construct( "/bundles/OrgNews/Vankor/", "/css/vankor", "/js/vankor/", self:: CATALOG_SECTION_ID );
    }
    /**
     * @Route("/vankor_news", name="vankor_all_news", methods={"GET"})     */
    public function index()
    {
        $options = [
            "template" => "index.html.twig",
            "news_count" => 11,
            "comments_count" => 10 ,
        ];
        return $this -> newsIndex( $options );
    }

    /**
     * @Route("/vankor_news/archive/{year}/{month}/{day}", name="vankor_news_archive", methods={"GET"})
     */
    public function archive( $year = 0, $month = 0, $day = 0 )
    {
        $options = [
          "template" => "/archive.html.twig",
          "last_news_count" => 5,
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
        'template' => "view.html.twig",
        'news_count' => 11,
        'last_news_count' => 3,
        'id' => $id,
      ];
      return $this -> newsShow( $options );
    }
}
