<?php
namespace ThisApp\Models;

use \ThisApp\Aplication\System\DB;
use \ThisApp\Aplication\Entities\Test as eTest;

class Test
{
	public $_data,
			$_db;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function lists()
	{
		if (!$this->_db->query("SELECT * FROM Test;")->error()) {
				return $this->_db->results();
				}
	}

	public function listTheseColumns(array $fields)
	{
		if (!$this->_db->query("SELECT ". implode(",",$fields) ." FROM Test;")->error()) {
					return $this->_db->results();
				}
	}
}