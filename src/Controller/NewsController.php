<?php
namespace App\Controller;

use App\Entity\RnComments;
use App\Entity\RnContent;
use App\Entity\RnPhotos;
use App\Repository\RnCommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use App\Controller\BaseDoctrineController;
use App\Controller\QueryOptions;

abstract class NewsController extends BaseDoctrineController
{
	const CATALOG_SECTION_ID = 26;
	const TARGET_TYPE = "Entities\\content";
	const SMALL_IMG_PATH = "/images/content/small";
	const MEDIUM_IMG_PATH = "/images/content/medium";
	// const LARGE_IMG_PATH = "/images/content/large";
    const LARGE_IMG_PATH = "/images/content/original";
	const ORIGINAL_IMG_PATH = "/images/content/original";
	const MIN_YEAR = 2014;
	const LIST_TEMPLATE = "list.html.twig";
	const VIEW_TEMPLATE = "view.html.twig";
	const INDEX_TEMPLATE = "index.html.twig";

    const DIGEST_COUNT = 10;
    const NEWS_COUNT = 11;
    const LAST_NEWS_COUNT = 5;

    protected $templates_path;
    protected $css_path;
    protected $js_path;

    protected $em;

    public function __construct( $templates_path, $css_path, $js_path )
    {
        $this -> templates_path = $templates_path;
        $this -> css_path = $css_path;
        $this -> js_path = $js_path;
    }

	public function getDigest( int $count )
	{
      $queryOptions = [
                    "select" => "content",
                    "from" => [ RNContent::class, 'content' ],
                    "where" => [
                                    'content.catalogSection = '. self :: CATALOG_SECTION_ID
                                ],
                    "order_by" => [ 'content.id', 'DESC' ],
                    "max_results" => $count
                ];
          return  $this -> GetVerboseBaseData( $queryOptions ) ;
	}

	public function getNews( int $count, int $year = 0 , int $month = 0 , int $day = 0 ): Array
	{

    if( ! $count )
       $count = 1;

      $queryOptionsObject = new QueryOptions;
      $queryOptionsObject -> addSelect( "content" )
                          -> addSelect( "photos" )
                          -> addFrom( RNContent::class, 'content' )
                          -> addJoin( RNPhotos::class, 'photos', 'content.id = photos.typeId' )
                          -> addWhere( 'content.catalogSection = '. self :: CATALOG_SECTION_ID )
                          -> addWhere( "photos.main = 1" )
                          -> addOrderBy( 'content.id', 'DESC' )
                          -> addMaxResults( $count );

    if( $year )
        $queryOptionsObject -> addWhere( "year( content.publishDate ) = $year");
    if( $month )
        $queryOptionsObject -> addWhere( "month( content.publishDate ) = $month");
    if( $day )
        $queryOptionsObject -> addWhere( "day( content.publishDate ) = $day");

      $queryOptions = [
                    "select" => "content, photos",
                    "from" => [ RNContent::class, 'content' ],
                    "join" => [
                                    [
                                        RNPhotos::class,
                                        'photos',
                                        'content.id = photos.typeId'
                                    ]
                                ],
                    "where" => [
                                    'content.catalogSection = '. self :: CATALOG_SECTION_ID
                                ],
                    "order_by" => [ 'content.id', 'DESC' ],
                    "max_results" => $count

                ];

        $this -> addWhere( $queryOptions, "photos.main = 1");

        if( $year )
            $this -> addWhere( $queryOptions, "year( content.publishDate ) = $year");
        if( $month )
            $this -> addWhere( $queryOptions, "month( content.publishDate ) = $month");
        if( $day )
            $this -> addWhere( $queryOptions, "day( content.publishDate ) = $day");

        $result =  $this -> GetVerboseBaseData( $queryOptions ) ;
        $result =  $this -> GetVerboseBaseDataWithQueryOptions( $queryOptionsObject ) ;

        $result_arr = [];
        $key = 0 ;

        for( $i = 0 ; $i < count( $result ) ; $i += 2 )
        {
            $result_arr[$key]["id"] = $result[$i]["id"];
            $result_arr[$key]["title"] = $result[$i]["title"];
            $result_arr[$key]["shortText"] = $result[$i]["shortText"];
            $result_arr[$key]["publishDate"] = $result[$i]["publishDate"];
            $result_arr[$key]["day"] = $result[$i]["publishDate"] ->format('j');
            $result_arr[$key]["month"] = $result[$i]["publishDate"] ->format('n');
            $result_arr[$key]["year"] = $result[$i]["publishDate"] ->format('Y');
            $result_arr[$key]["image"] = $result[ $i + 1 ]["name"];
            $key ++ ;
        }

		return $result_arr;
	} // public function getNews

	public function getComments( int $count )
	{
      $queryOptions = [
                    "select" => "comment, content",
                    "from" => [ RNComments::class, 'comment' ],
                    "join" => [
                                    [
                                        RNContent::class,
                                        'content',
                                        'content.id = comment.targetId'
                                    ]
                                ],
                    "where" => [ 'comment.isModered = 1' ],
                    "order_by" => [ 'comment.id', 'DESC' ],
                    "max_results" => $count
                ];

      $result =  $this -> GetVerboseBaseData( $queryOptions ) ;

        $result_arr = [];
        $key = 0 ;

        for( $i = 0 ; $i < count( $result ) ; $i += 2 )
        {
            $result_arr[$key]["text"] = $result[$i]["text"];
            $result_arr[$key]["isAnonim"] = $result[$i]["isAnonim"];
            $result_arr[$key]["employeeId"] = $result[$i]["employeeId"];
            $result_arr[$key]["employeeName"] = $result[$i]["employeeName"];
            $result_arr[$key]["targetId"] = $result[$i]["targetId"];
            $result_arr[$key]["isModered"] = $result[$i]["isModered"];
            $result_arr[$key]["title"] = isset( $result[$i+1]["title"] ) ? $result[$i+1]["title"] : "";
        }

        return $result_arr;

	} // public function getComments

	public function getNew( int $id )
	{
		return $this -> GetBaseDataFind( $id, RnContent::class);
	}

    public function newsByDate( $options ): Response
    {
        $template = self :: LIST_TEMPLATE;
        $calendar_path = $this -> getOption( $options, "calendar_path", "" );
        $newsCount = $this -> getOption( $options, "news_count", 0 );
        $lastNewsCount = self :: LAST_NEWS_COUNT;
        $year = $this -> getOption( $options, "year", 0 );
        $month = $this -> getOption( $options, "month", 0 );
        $day = $this -> getOption( $options, "day", 0 );

        if( $year == 0 )
            $year = date("Y");

    	$nowDate = [ 'year' => $year , 'month' => $month ];
        $calendar = 0 ;

        if( strlen( $calendar_path ) && $month )
        {
          $path = $this->generateUrl( $calendar_path )."/$year/$month";
          $calendar =  $this -> getCalendar( $year, $month, $path );
        }

        $news = $this -> getNews( $newsCount, $year, $month, $day );
        $month_arr = $this -> getmonthArr();

        return $this->render( $this -> templates_path.$template,
        [
            'templates_path' => $this -> templates_path,
            'title' => 'Архив новостей',
            'news' => $news,
            'lastNews' => $this -> getNews( $lastNewsCount ),

            'current_day' => $day,
            'current_month' => $month,
            'current_year' => $year,

            'years' => range( self :: MIN_YEAR, date("Y") ),
            'css_path' => $this -> css_path,
            'js_path' => $this -> js_path,

            'nowDate' => $nowDate,
            'image_path' => self :: SMALL_IMG_PATH,
            'type' => 'feed',
            'months_vsnk' => $month_arr,
            'calendar' => $calendar,
        ]
     );
    } // public function newsByDate


    public function newsShow( $options ): Response
    {
        $template = self :: VIEW_TEMPLATE;
        $news_count = $this -> getOption( $options, "news_count", 0 );
        $last_news_count = $this -> getOption( $options, "last_news_count", 0 );
        $comments_count = $this -> getOption( $options, "comments_count", 0 );
        $digest_count = $this -> getOption( $options, "digest_count", 0 );
        $id = $this -> getOption( $options, "id", 0 );
        $calendar_path = $this -> getOption( $options, "calendar_path", "" );

        $curnews = $this -> GetBaseDataFind( $id, RnContent::class );

        $raw_comments = $this->GetBaseDataFindBy( $id, RnComments::class, [ "targetId" => $id, "isModered" => 1 ]);

        $gallery = $this -> GetBaseDataFindByTypeId( $id, RnPhotos::class );

        $image = $curnews -> getPhoto();
        foreach ($gallery as $key => $picture)
        {
            $picture_name = $picture -> getName();
            $gallery[$key] -> large = self :: LARGE_IMG_PATH ."/$picture_name";
            $gallery[$key] -> small = self :: SMALL_IMG_PATH ."/$picture_name";
            $gallery[$key] -> original = self :: ORIGINAL_IMG_PATH ."/$picture_name";

            if( $picture -> getMain() )
            {
                $image = $picture -> getName();
                unset( $gallery[$key] );
            }
        }

        $data = $this -> getData( $news_count, $comments_count, $digest_count );

        $comments['comments'] = $raw_comments;
        foreach ($comments['comments'] as $key => $value) {
            $comments['comments'][$key] -> user =                [
                    "image" => "/images/anonim.jpg",
                    "employeeId" => 123,
                    "name" => "name",
                ];
         }

        $comments['commentsCount'] = count( $raw_comments );
        $comments['target_id'] = $curnews -> getId();
        $comments['target_type'] = self :: TARGET_TYPE;

        $news = $data['news'];
        foreach ($news as $key => $value)
            if( $value['id'] == $id )
                unset( $news[$key] );

        $publish_date = $curnews -> getPublishDate();
        $current_day = date_format( $publish_date, 'd');
        $current_month = date_format( $publish_date, 'm');
        $current_year = date_format( $publish_date, 'Y');

        if( strlen( $calendar_path ) )
            $calendar_path = $this->generateUrl($calendar_path);

        return $this->render( $this -> templates_path.$template, [

                'templates_path' => $this -> templates_path,
                'newsTitle' => $curnews -> getTitle(),
                'fullText' => $curnews -> getFullText(),
                'shortText' => $curnews -> getShortText(),
                'date' => "$current_day.$current_month.$current_year",
                'targetId' => $curnews -> getId(),
                'targetType' => self :: TARGET_TYPE,

                'image' => $image,
                'gallery' => $gallery,
                'comments' => $comments,
                'lastNews' => array_slice( $news, 0, $last_news_count ),
                'newsDigest' => $data['digest'],
                'css_path' => $this -> css_path,
                'js_path' => $this -> js_path,
                'years' => range( self :: MIN_YEAR, date("Y") ),
                'current_year' => $current_year,
                'current_month' => $current_month,
                'calendar' =>  $this -> getCalendar( $current_year, $current_month, $calendar_path."/$current_year/$current_month" ),
            ]);
    } // public function news_show(


    public function getData( $news_count, $comments_count, $digest_count )
    {
        $digest = $this -> getDigest( $digest_count );
        $news = $this -> getNews( $news_count );
        $comments = $this -> getComments( $comments_count );

        foreach ( $news as $key => $value )
        {
            $news[$key]["publishDate"] = date_format($value["publishDate"], 'd.m.Y');
            $news[$key]['countComments'] = 0;
        }

        foreach ( $comments as $key => $comment ) {
            $arr = explode("\\", $comment["employeeName"]);
            $comments[$key]["user"] = ["name" => isset( $arr[2] ) ? $arr[2] : ""] ;
        }

         return [ 'digest' => $digest, 'comments' => $comments , 'news' => $news ];
    } // public function getData

    /**
     * @Route("/ajax_add_comment", name="ajax_add_comment", methods={"POST"})
    */
    public function addComment( Request $request, RouterInterface $router ): Response
    {
        $result = false;

        $req = $request->request;
        $comment_text = $req ->get('comment');
        $target_id = $req->get('target_id');
        $target_type = $req->get('target_type');
        $employeeId = $req->get('employee_id');
        $employeeName = $req->get('employee_name');

        if( strlen( $comment_text ) && $target_id )
        {
            $em = $this->getDoctrine()->getManager();
            $comment = new RnComments();
            $comment -> setText( $comment_text );
            $comment -> setTargetId( $target_id );
            $comment -> setTargetType( $target_type );
            $comment -> setEmployeeId( $employeeId );
            $comment -> setEmployeeName( $employeeName );
            $comment -> setDateCreate( new \DateTime() );
            $em->persist($comment);
            $em->flush();
            $result = true;
        }
        else
            if( ! $target_id )
                return new RedirectResponse($router->generate('app_homepage'));

        return new Response( $result );
    } // public function addComment

     public function newsIndex( $options ): Response
    {
         $template = self :: INDEX_TEMPLATE;

         $news_count = $this -> getOption( $options, "news_count", 0 );
         $comments_count = $this -> getOption( $options, "comments_count", 0 );
         $digest_count  = $this -> getOption( $options, "digest_count", 0 );

		$data = $this -> getData( $news_count, $comments_count, $digest_count );
        return $this-> render( $this -> templates_path.$template,
            [
                'templates_path' => $this -> templates_path,
                'css_path' => $this -> css_path,
                'js_path' => $this -> js_path,
                'title' => 'Новости',
                'news' => $data['news'],
                'comments' => $data['comments'],
                'digest' => $data['digest'],
            ]);
    } // public function newsIndex

    public function getCalendar( $year, $month , $path = '' )
    {

      $queryOptions = [
                    "select" => "day( content.publishDate ) AS day",
                    "from" => [ RNContent::class, "content"],
                    "join" => [
                                    [
                                        RNPhotos::class,
                                        "photos",
                                        "content.id = photos.typeId"
                                    ]
                                ],
                    "where" => [
                                    "year( content.publishDate ) = $year",
                                    "month( content.publishDate ) = $month",
                                    "content.catalogSection = ". self :: CATALOG_SECTION_ID,
                                    "photos.main = 1"
                                ],
                ];

      $result =  $this -> GetVerboseBaseData( $queryOptions ) ;
      $days = array_flip( array_column( $result, 'day'));
      $str = "";
      // Вычисляем число дней в текущем месяце
      $dayofmonth = date('t');
      // Счётчик для дней месяца
      $day_count = 1;
      // 1. Первая неделя
      $num = 0;
      for( $i = 0; $i < 7; $i ++ )
      {
        // Вычисляем номер дня недели для числа
        $dayofweek = date('w', mktime(0, 0, 0, $month, $day_count, $year ));

        // Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
        $dayofweek -= 1;

        if($dayofweek == -1)
            $dayofweek = 6;

        if($dayofweek == $i)
        {
          // Если дни недели совпадают, заполняем массив $week числами месяца
          $week[$num][$i] = $day_count;
          $day_count++;
        }
        else
          $week[$num][$i] = "";
      }
      // 2. Последующие недели месяца
      while(true)
      {
        $num++;
        for($i = 0; $i < 7; $i++)
        {
          $week[$num][$i] = $day_count;
          $day_count ++;
          // Если достигли конца месяца - выходим из цикла
          if($day_count > $dayofmonth)
            break;
        }
        // Если достигли конца месяца - выходим из цикла
        if($day_count > $dayofmonth)
            break;
      }

      // 3. Выводим содержимое массива $week виде календаря
      // Выводим таблицу

      for($i = 0; $i < count($week); $i++)

      {
        $str .= "<tr>";
        for($j = 0; $j < 7; $j++)
        {
          if(!empty($week[$i][$j]))
          {
            $day = $week[$i][$j];
            // Если имеем дело с субботой и воскресенья подсвечиваем их
            // if($j == 5 || $j == 6)

            //      $str .= "<td><font color=red>".$week[$i][$j]."</font></td>";
            // else

            if( isset( $days[ $day ] ))
              $str .= "<td><a href='$path/$day'><strong>$day</strong></a></td>";
              else
                $str .= "<td>$day</td>";
          }
          else
            $str .= "<td>&nbsp;</td>";
        }
        $str .= "</tr>";
      }
    return $str;

    }// public function getCalendar

    public function getOption( $options, $key, $default_value )
    {
        return isset( $options[ $key ] ) ? $options[ $key ] :  $default_value;
    }

    public function getMonthArr()
    {
        return [
                    [
                        'number' => 1,
                        'name' => 'январь'
                    ],
                    [
                        'number' => 2,
                        'name' => 'февраль'
                    ],
                    [
                        'number' => 3,
                        'name' => 'март'
                    ],
                    [
                        'number' => 4,
                        'name' => 'апрель'
                    ],
                    [
                        'number' => 5,
                        'name' => 'май'
                    ],
                    [
                        'number' => 6,
                        'name' => 'июнь'
                    ],
                    [
                        'number' => 7,
                        'name' => 'июль'
                    ],
                    [
                        'number' => 8,
                        'name' => 'август'
                    ],
                    [
                        'number' => 9,
                        'name' => 'сентябрь'
                    ],
                    [
                        'number' => 10,
                        'name' => 'октябрь'
                    ],
                    [
                        'number' => 11,
                        'name' => 'ноябрь'
                    ],
                    [
                        'number' => 12,
                        'name' => 'декабрь'
                    ],
                  ];
    }

}
