<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseDoctrineController extends AbstractController
{
    protected $entity = "";
    protected $alias = "";
    protected $orderBy = "";
    protected $dir = "";

    protected $maxResults = 0;
    protected $where = [];

    protected function GetBaseDataRepository( $entity )
    {
        return $this->getDoctrine()->getRepository( $entity );
    }
    protected function GetBaseDataFind( $id, $entity )
    {
        return $this->GetBaseDataRepository( $entity )->find( $id );
    }

    protected function GetBaseDataFindBy( $id, $entity, $arr )
    {
        return $this->GetBaseDataRepository( $entity )->findBy( $arr );
    }

    protected function GetBaseDataFindByTypeId( $id, $entity )
    {
        return $this->GetBaseDataRepository( $entity )->findByTypeId( $id );
    }

    protected function GetBaseData()
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


    protected function GetUnifiedBaseData( $option )
    {
        $queryBuilder = $this->getDoctrine()
                    ->getManager()
                    ->createQueryBuilder()
                    ->select( $option['select'] )
                    ->from( $option["from"][0], $option["from"][1] );

        foreach( $option["join"] AS $value )
            $queryBuilder = $queryBuilder
                        ->leftJoin(
                            $value[0],
                            $value[1],
                            "with",
                            $value[2]
                        );

        foreach( $option["where"] AS $value )
            $queryBuilder = $queryBuilder
                        ->andWhere( $value );

        if( isset( $option["max_results"] ) )
            $queryBuilder = $queryBuilder->setMaxResults( $option["max_results"] );

        if( isset( $option["order_by"] ) )
            $queryBuilder = $queryBuilder->orderBy( $option["order_by"][0], $option["order_by"][1] );

        return  $queryBuilder
                    ->getQuery()
                    ->getResult( \Doctrine\ORM\Query::HYDRATE_ARRAY );
    }
}
