<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    protected $entity = "";
    protected $alias = "";
    protected $orderBy = "";
    protected $dir = "";

    protected $maxResults = 0;
    protected $where = [];

    protected function GetBaseData1( $id = 0 )
    {
        $em = $this->getDoctrine()
            ->getRepository( $this -> entity );

        if( $id )
            $result = $em -> find( $id );
                else
                    $result = $em -> findAll();

        return $result;
    }


    protected function GetBaseData( $id = 0 )
    {
        $queryBuilder = $this->getDoctrine()
                    ->getManager()
                    ->createQueryBuilder()
                    ->select( $this -> alias )
                    ->from($this -> entity, $this -> alias );

        foreach( $this -> where AS $value )
            $queryBuilder = $queryBuilder
                        ->andWhere( "$value" );

        if( strlen( $this -> orderBy ) )
            $queryBuilder = $queryBuilder
                    ->orderBy( $this -> orderBy, $this -> dir );

        if( $this -> maxResults )
            $queryBuilder = $queryBuilder -> setMaxResults( $this -> maxResults );

        return  $queryBuilder
                    ->getQuery()
                    ->getResult();

    }
}
