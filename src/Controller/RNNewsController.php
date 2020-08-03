<?php

namespace App\Controller;

// use Sibintek\NewsBundle\Entity\OrgNews;
use App\Entity\RnComments;
use App\Entity\RnContent;
use App\Entity\RnPhotos;

use App\Repository\RnCommentsRepository;

use App\Form\RNCommentsType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class RNNewsController extends AbstractController
{

    private $commentRepository;

    public function __construct(RnCommentsRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/rnnews", name="rnnews_index", methods={"GET"})
     */
    public function index(): Response
    {
		$data = $this -> getData();
        return $this->render('/bundles/OrgNews/index.html.twig', [

            'news' => $data['news'],
            'oilCounter' => '209150',
            'oilCounterForDay' => '41173',
            'gazCounterGazprom' => '33200',
            'gazCounterPpd' => '8622',
            'comments' => $data['comments'],
            'digest' => $data['digest'],

            'today_date' => '28 ',
            'today_day' => 'среда',
            'today_month' => 'июль',
            'today_time' => '13:30',
            'currentUser' => [
                'getPhoto' => 'photo',
                'name' => 'Иванов Иван Иванович',
                'employee_id' => 123
            ]
        ]);
    }


    /**
     * @Route("/rnnews/archive", name="rnnews_archive", methods={"GET"})
     */
    public function archive(): Response
    {
            $data = $this -> getData();
            $news = $data['news'];

            return $this->render('/bundles/OrgNews/archive.html.twig',
            [
                'news' => $news,
                'oilCounter' => '209150',
                'oilCounterForDay' => '41173',
                'gazCounterGazprom' => '33200',
                'gazCounterPpd' => '8622',
                'lastNews' => array_slice( $news, 0, 3 ),

                'months' => [],
                'years' => [],

                'today_date' => date("d"),
                'today_day' => date("l"),
                'current_day' => date("l"),
                'today_month' => date("F"),
                'current_month' => date("F"),
                'today_time' => date("H:i"),
                'currentUser' => [
                    'getPhoto' => 'photo',
                    'employeeImage' => 'photo',
                    'name' => 'Иванов Иван Иванович',
                    'employee_id' => 123
                ]
            ]
        );
    }

    /**
     * @Route("/rnnews/{id}", name="rnnews_show", methods={"GET"})
     */
    public function show( int $id ): Response
    {
    	date_default_timezone_set('Asia/Krasnoyarsk');
    	$curnews = $this->getDoctrine()
            ->getRepository(RnContent::class)
            ->find( $id );

    	$comments = $this->getDoctrine()
            ->getRepository(RnComments::class)
            ->findByTargetId( $id );

    	$gallery = $this->getDoctrine()
            ->getRepository(RnPhotos::class)
            ->findByTypeId( $id );

        $image = $curnews -> getPhoto();
        foreach ($gallery as $key => $picture)
        {
        	$gallery[$key] -> large = '/images/content/medium/'.$picture -> getName();
        	$gallery[$key] -> small = '/images/content/small/'.$picture -> getName();

        	if( $picture -> getMain() )
        	{
        		$image = $picture -> getName();
        		unset( $gallery[$key] );
        	}
        }

        $targetType = "Entities\\content";
        $data = $this -> getData();

        $twig_comments['comments'] = $comments;

        foreach ($twig_comments['comments'] as $key => $value) {
            $twig_comments['comments'][$key] -> user =                [
                    "image" => "",
                    "employee_id" => 123,
                    "name" => "name",
                ];
         }

        $twig_comments['commentsCount'] = count( $comments );
        $twig_comments['target_id'] = $curnews -> getId();
        $twig_comments['target_type'] = $targetType;

        $news = $data['news'];
        foreach ($news as $key => $value)
            if( $value['getId'] == $id )
                unset( $news[$key] );

        return $this->render('/bundles/OrgNews/view.html.twig', [

                'newsTitle' => $curnews -> getTitle(),
                'fullText' => $curnews -> getFullText(),
                'date' => date_format( $curnews -> getPublishDate(), 'd.m.Y'),
                'target_id' => $curnews -> getId(),
                'target_type' => $targetType,

        		'image' => $image,
        		'gallery' => $gallery,
        		'comments' => $twig_comments,
            	'lastNews' => array_slice( $news, 0, 3 ),
            	'newsDigest' => $data['digest'],
    			'today_date' => date("d"),
	            'today_day' => date("l"),
	            'today_month' => date("F"),
	            'today_time' => date("H:i"),
	            'currentUser' => [
                    'getPhoto' => 'photo',
                    'employeeImage' => 'photo',
                    'name' => 'Иванов Иван Иванович',
                    'employee_id' => 123
		        ]
		    ]);
    }


    public function getData(){

        $doctrine = $this->getDoctrine();
        $digest =
            $doctrine
            ->getRepository(RnContent::class)
            ->createQueryBuilder('b')
            ->select("b.id, b.title")
            ->andWhere('b.catalogSection = 26')
            ->orderBy('b.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
        $news =
            $doctrine
            ->getManager()
            ->createQueryBuilder()
            ->select('
                    content.id AS getId,
                    content.shortText AS getShort_text,
                    content.title AS getTitle,
                    content.publishDate AS getDate,
                    photos.name AS getPhoto
                    ')
            ->from(RNContent::class, 'content')
            ->leftJoin(RNPhotos::class, 'photos', 'with', 'content.id = photos.typeId')
            ->andWhere('content.catalogSection = 26')
            ->andWhere('photos.main = 1')
            ->orderBy('content.id', 'DESC')
            ->setMaxResults(11)
            ->getQuery()
            ->getResult();

        foreach ( $news as $key => $value )
        {
            $news[$key]["getDate"] = date_format($value["getDate"], 'd.m.Y');
            $news[$key]['countComments'] = 0;
        }

        $comments = $doctrine->getManager()
            ->createQueryBuilder()
            ->select('
                    comment.text,
                    comment.isAnonim AS is_anonim,
                    comment.employeeId,
                    comment.employeeName,
                    comment.employeeId AS employee_id,
                    comment.targetId AS target_id,
                    content.title')
            ->from(RNComments::class, 'comment')
            ->leftJoin(RNContent::class, 'content', 'with', 'content.id = comment.targetId')
            ->orderBy('comment.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        foreach ( $comments as $key => $comment ) {
            $arr = explode("\\", $comment["employeeName"]);
            $comments[$key]["user"] = ["name" => isset( $arr[2] ) ? $arr[2] : "zzz"] ;
        }

         return [ 'digest' => $digest, 'comments' => $comments , 'news' => $news ];
    }
    /**
     * @Route("/ajax_add_comment", name="ajax_add_comment")
     */
    public function addComment(Request $request, RouterInterface $router ): Response
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
}
