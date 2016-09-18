<?php
namespace ThisApp\Models;
use \ThisApp\Aplication\System\DB;

class Path 
{
	public $id,
	 $sitio,
	 $absoluta,
	 $_data,
			$_db;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function get()
	{	
		return $this->query("SELECT * from absolutas");	
	}
/*
NO AMBIGUEAD, PORQUE DUNCIONA
*/
	public function query($query, $params = array() )
	{
		if(count($params)> 0)
			$result = $this->_db->get($query, $params);
		else
			$result = $this->_db->query($query);	
		return !$result->count() ? '0': $result->first();
	}
}
