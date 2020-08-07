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

abstract class NewsController extends AbstractController
{
	const TARGET_TYPE = "Entities\\content";

	const SMALL_IMG_PATH = "/images/content/small";
	const MEDIUM_IMG_PATH = "/images/content/medium";
	const LARGE_IMG_PATH = "/images/content/large";
	const ORIGINAL_IMG_PATH = "/images/content/original";

	public function getDigest( int $count )
	{
		return  $this->getDoctrine()
		            ->getRepository(RnContent::class)
		            ->createQueryBuilder('c')
		            ->select("c.id, c.title, c.publishDate")
		            ->andWhere('c.catalogSection = 26')
		            ->orderBy('c.id', 'DESC')
		            ->setMaxResults( $count )
		            ->getQuery()
		            ->getResult();
	}
	public function getNews( int $catalogSection, int $count, int $year = 0 , int $month = 0 , int $day = 0 )
	{
		$queryBuilder = $this->getDoctrine()
		            		 ->getManager()
		            		 ->createQueryBuilder();
		 $queryBuilder
		            ->select('
		                    content.id,
		                    content.title,
		                    content.shortText,
		                    content.publishDate,
		                    photos.name AS image
		                    ')
		            ->from(RNContent::class, 'content')
		            ->leftJoin(RNPhotos::class, 'photos', 'with', 'content.id = photos.typeId')
		            ->andWhere('content.catalogSection = '. $catalogSection )
		            ->andWhere('photos.main = 1');

        if( $year )
            $queryBuilder = $queryBuilder ->andWhere("year( content.publishDate ) = $year");
        if( $month )
            $queryBuilder = $queryBuilder ->andWhere("month( content.publishDate ) = $month");
        if( $day )
            $queryBuilder = $queryBuilder ->andWhere("day( content.publishDate ) = $day");

		$queryBuilder = $queryBuilder->orderBy('content.id', 'DESC');

        if( $count )
			$queryBuilder = $queryBuilder->setMaxResults( $count );

		return  $queryBuilder
		            ->getQuery()
		            ->getResult();
	}

	public function getComments( int $count )
	{
		return  $this->getDoctrine()
					->getManager()
		            ->createQueryBuilder()
		            ->select('
		                    comment.text,
		                    comment.isAnonim,
		                    comment.employeeId,
		                    comment.employeeName,
		                    comment.employeeId,
		                    comment.targetId,
		                    comment.isModered,
		                    content.title')
		            ->from(RNComments::class, 'comment')
		            ->leftJoin(RNContent::class, 'content', 'with', 'content.id = comment.targetId')
		            ->andWhere('comment.isModered = 1')
		            ->orderBy('comment.id', 'DESC')
		            ->setMaxResults( $count )
		            ->getQuery()
		            ->getResult();
	}

	public function getNew( int $id )
	{
		return $this->getDoctrine()
		            ->getRepository(RnContent::class)
		            ->find( $id );
	}

	public function getGallery( int $id )
	{
		return $this->getDoctrine()
		            ->getRepository(RnPhotos::class)
		            ->findByTypeId( $id );
	}

    public function newsByDate(
    	$catalog_section_id,
    	$template,
    	$templates_path,
    	$css_path,
        $js_path,
        $url_path, // переход с календаря

        $newsCount = 11,
    	$lastNewsCount = 3,
    	$year = 0,
    	$month = 0,
    	$day = 0 ): Response
    {
    	$nowDate = [ 'year' => $year , 'month' => + $month ];

        $calendar = 0 ;

        if( strlen( $url_path ) && $month )
        {
          $path = $this->generateUrl( $url_path )."/$year/$month";
          $calendar =  $this -> getCalendar( $year, $month, $catalog_section_id, $path );
        }

            if( $year || $month || $day )
            {
                $queryBuilder = $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder()
                ->select('
                        content.id AS id,
                        content.shortText,
                        content.title AS title,
                        content.publishDate,
                        day(content.publishDate) AS day,
                        month(content.publishDate) AS month,
                        year(content.publishDate) AS year,
                        photos.name AS image
                        ')
                ->from(RNContent::class, 'content')
                ->leftJoin(RNPhotos::class, 'photos', 'with', 'content.id = photos.typeId')
                ->andWhere('photos.main = 1')
                ->andWhere("content.catalogSection = $catalog_section_id "  );

                if( $year )
                    $queryBuilder = $queryBuilder ->andWhere("year( content.publishDate ) = $year");
                if( $month )
                    $queryBuilder = $queryBuilder ->andWhere("month( content.publishDate ) = $month");
                if( $day )
                    $queryBuilder = $queryBuilder ->andWhere("day( content.publishDate ) = $day");

                $news = $queryBuilder->orderBy('content.id', 'DESC')
                                          ->getQuery()
                                          ->getResult();
            }
            else
                $news = $this -> getNews( $catalog_section_id, $newsCount );

            $months_in_date = [
                            1 => "января",
                            2 => "февраля",
                            3 => "марта",
                            4 => "апреля",
                            5 => "мая",
                            6 => "июня",
                            7 => "июля",
                            8 => "августа",
                            9 => "сентября",
                            10 => "октября",
                            11 => "ноября",
                            12 => "декабря",
                        ];

                    $month_arr = [
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

            $years = range( 2011, 2020 );
            $data = $this -> getData( $catalog_section_id );

            dump( $news );

            return $this->render( $templates_path.$template,
            [
                'templates_path' => $templates_path,
                'title' => 'Архив новостей',
                'news' => $news,
                'lastNews' => $this -> getNews( $catalog_section_id, $lastNewsCount ),

                'current_day' => $day,
                'current_month' => $month,
                'current_year' => $year,

                'months_in_date' => $months_in_date,
                'years' => $years,
                'css_path' => $css_path,
                'js_path' => $js_path,

                'nowDate' => $nowDate,
                'image_path' => self :: SMALL_IMG_PATH,
                'type' => 'feed',
                'months_vsnk' => $month_arr,
                'calendar' => $calendar,
            ]
        );
    }


    public function news_show( string $template, string $templates_path, int $catalog_section_id, string $news_count, int $last_news_count, string $css_path, string $js_path, int $comments_count, int $digest_count, int $id ): Response
    {
    	$curnews = $this->getDoctrine()
            ->getRepository(RnContent::class)
            ->find( $id );

    	$raw_comments = $this->getDoctrine()
            ->getRepository(RnComments::class)
            ->findBy( [ "targetId" => $id, "isModered" => 1 ] );

    	$gallery = $this->getDoctrine()
            ->getRepository(RnPhotos::class)
            ->findByTypeId( $id );

        $image = $curnews -> getPhoto();
        foreach ($gallery as $key => $picture)
        {
        	$gallery[$key] -> large = self :: LARGE_IMG_PATH . $picture -> getName();
        	$gallery[$key] -> small = self :: SMALL_IMG_PATH . $picture -> getName();

        	if( $picture -> getMain() )
        	{
        		$image = $picture -> getName();
        		unset( $gallery[$key] );
        	}
        }

        $data = $this -> getData( $catalog_section_id, $news_count, $comments_count, $digest_count );

        $comments['comments'] = $raw_comments;
        foreach ($comments['comments'] as $key => $value) {
            $comments['comments'][$key] -> user =                [
                    "image" => "",
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

        return $this->render( $templates_path.$template, [

                'templates_path' => $templates_path,
                'newsTitle' => $curnews -> getTitle(),
                'fullText' => $curnews -> getFullText(),
                'shortText' => $curnews -> getShortText(),
                'date' => date_format( $curnews -> getPublishDate(), 'd.m.Y'),
                'targetId' => $curnews -> getId(),
                'targetType' => self :: TARGET_TYPE,

        		'image' => $image,
        		'gallery' => $gallery,
        		'comments' => $comments,
            	'lastNews' => array_slice( $news, 0, $last_news_count ),
            	'newsDigest' => $data['digest'],

            	'css_path' => $css_path,
            	'js_path' => $js_path,
		    ]);
    }

    public function getData( $catalog_section_id, $news_count = 10 , $comments_count = 10 , $digest_count = 5 )
    {
        $digest = $this -> getDigest( $digest_count );
        $news = $this -> getNews( $catalog_section_id, $news_count );
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
    }

    public function newsAddComment( Request $request, RouterInterface $router ): Response
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
    }

    public function news_index( $catalog_section_id, $template, $templates_path, $news_count, $comments_count = 10 , $digest_count = 3 ): Response
    {
		$data = $this -> getData( $catalog_section_id, $news_count, $comments_count, $digest_count );

        return $this-> render( $templates_path.$template,
            [
                'templates_path' => $templates_path,
                'title' => 'Новости',
                'news' => $data['news'],
                'comments' => $data['comments'],
                'digest' => $data['digest'],
            ]);
    }

    public function getCalendar( $year = 2020, $month = 1, $catalogSection, $path = '' )
    {
      $days = array_flip( array_column( $this->getDoctrine()
                   ->getManager()
                   ->createQueryBuilder()
                   ->select('day( content.publishDate ) AS day')
                   ->from(RNContent::class, 'content')
                   ->leftJoin(RNPhotos::class, 'photos', 'with', 'content.id = photos.typeId')
                   ->andWhere("year( content.publishDate ) = $year")
                   ->andWhere("month( content.publishDate ) = $month")
                   ->andWhere('content.catalogSection = '. $catalogSection )
                   ->andWhere('photos.main = 1')
                   ->getQuery()
                   ->getResult(), 'day' ));

        $str = "";
          // Вычисляем число дней в текущем месяце
          $dayofmonth = date('t');
          // Счётчик для дней месяца
          $day_count = 1;
          // 1. Первая неделя
          $num = 0;
          for($i = 0; $i < 7; $i++)
          {
            // Вычисляем номер дня недели для числа
            $dayofweek = date('w', mktime(0, 0, 0, $month, $day_count, $year ));

            // Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
            $dayofweek = $dayofweek - 1;

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
    }
}
