<?php
namespace App\Controller;

class QueryOptions
{
	private $select = [];
    private $from = [];
	private $where = [];
	private $join = [];
	private $order_by = [];
	private $max_results = 0;

	public function addSelect( string $select )
	{
		$this -> select[] = $select;
		return $this;
	}

	public function getSelect()
	{
		return join(",", $this -> select );
	}

	public function addFrom( $entity, $alias )
	{
		$this -> from = [ "entity" => $entity, "alias" => $alias ];
		return $this;
	}

	public function getFromEntity()
	{
		return $this -> from["entity"] ;
	}

	public function getFromAlias()
	{
		return $this -> from["alias"] ;
	}

	public function addJoin( $entity, $alias, $expression )
	{
		$this -> join[] = [ "entity" => $entity, "alias" => $alias, "expression" => $expression ];
		return $this;
	}

	public function hasJoin()
	{
		return count( $this -> join );
	}


	public function getJoin()
	{
		return $this -> join;
	}

	public function addWhere( $where )
	{
		$this -> where[] = $where;
		return $this;
	}

	public function hasWhere()
	{
		return count( $this -> where );
	}

	public function getWhere()
	{
		return $this -> where;
	}


	public function addOrderBy( $field, $direction )
	{
		$this -> order_by = [ "field" => $field, "direction" => $direction ];
		return $this;
	}

	public function hasOrderBy()
	{
		return count( $this -> order_by );
	}

	public function getOrderByField()
	{
		return $this -> order_by[ "field" ];
	}

	public function getOrderByDirection()
	{
		return $this -> order_by[ "direction" ];
	}

	public function addMaxResults( $max_results )
	{
		$this -> max_results = $max_results;
		return $this;
	}

	public function getMaxResults()
	{
		return $this -> max_results;
	}

}