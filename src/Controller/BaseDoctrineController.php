<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\QueryOptions;

abstract class BaseDoctrineController extends AbstractController
{
    // get repository
    protected function GetBaseDataRepository( $entity )
    {
        return $this->getDoctrine()->getRepository( $entity );
    }

    // find
    protected function GetBaseDataFind( $id, $entity )
    {
        return $this->GetBaseDataRepository( $entity )->find( $id );
    }

    // findBy
    protected function GetBaseDataFindBy( $id, $entity, $arr )
    {
        return $this->GetBaseDataRepository( $entity )->findBy( $arr );
    }

    // findByTypeId
    protected function GetBaseDataFindByTypeId( $id, $entity )
    {
        return $this->GetBaseDataRepository( $entity )->findByTypeId( $id );
    }

    // get detailed database request in functional style
    protected function GetVerboseBaseData( $option ) : Array
    {
        $queryBuilder = $this->getDoctrine()
                    ->getManager()
                    ->createQueryBuilder()
                    ->select( $option['select'] )
                    ->from( $option["from"][0], $option["from"][1] );

        if( isset( $option["join"] ) )
            foreach( $option["join"] AS $value )
                $queryBuilder = $queryBuilder
                            ->leftJoin(
                                $value[0],
                                $value[1],
                                "with",
                                $value[2]
                            );

        if( isset( $option["where"] ) )
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
    } // protected function GetVerboseBaseData( $option )

    public function addWhere( &$option , $where )
    {
        if( isset( $option["where"] ) )
            $option["where"][] = $where;
                else
                {
                    $option["where"] = [];
                    $option["where"][] = $where;
                }
    }

    // get detailed database request in OOP style
    protected function GetVerboseBaseDataWithQueryOptions( QueryOptions $option ): Array
    {
        $queryBuilder = $this->getDoctrine()
                    ->getManager()
                    ->createQueryBuilder()
                    ->select( $option -> getSelect() )
                    ->from( $option -> getFromEntity(), $option -> getFromAlias() );

        if( $option -> hasJoin() )
            foreach( $option -> getJoin() AS $value )
                $queryBuilder = $queryBuilder
                            ->leftJoin(
                                $value["entity"],
                                $value["alias"],
                                "with",
                                $value["expression"]
                            );

        if( $option -> hasWhere() )
            foreach( $option -> getWhere() AS $value )
                $queryBuilder = $queryBuilder
                            ->andWhere( $value );

        if( $option -> getMaxResults() )
            $queryBuilder = $queryBuilder->setMaxResults( $option -> getMaxResults() );

        if( $option -> hasOrderBy())
            $queryBuilder = $queryBuilder->orderBy( $option -> getOrderByField(), $option -> getOrderByDirection() );

        return  $queryBuilder
                    ->getQuery()
                    ->getResult( \Doctrine\ORM\Query::HYDRATE_ARRAY );
    } // function GetVerboseBaseDataWithQueryOptions( QueryOptions $option )

      public function debug( $arg )
      {
          echo "<pre>";
          print_r( $arg );
          echo "</pre>";
      }

      public function dd( $arg )
      {
        $this -> debug( $arg );
        die;
      }
}
