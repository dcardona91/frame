<?php
namespace ThisApp\Aplication\System;
//php data objet para deifinir cualquier base e datos c
class DB {
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error =  false, 
			$_results, 
			$_count = 0;

	public function __construct(){
		try {
			$this->_pdo = new \PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

/*
	Metodos base del sistema
*/
	public static function getInstance(){
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();	
			self::$_instance->query("SET NAMES utf8;");
		}
		return self::$_instance;
	}

	private function clean()
	{ 
		$this->_error =  false;
		$this->_results = NULL; 
		$this->_count = 0;
	}

	public function query($sql, $params =  array(),$control = null)
	{
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if(count($params)){
				foreach ($params as $param) {
					$this->_query->bindValue($x,$param);
					$x++;
				}
			}

			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(\PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			}
			else{
				$this->_error = true;
			}
		}
		return $this;
	}

	
	public function insert($table, array $cols)
	{
			end($cols);
			$last = key($cols);
			$positions = "";
				foreach ($cols as $key => $col) {
					$positions = $key==$last? $positions." ? " : $positions." ?, ";
				}	
			$columns = implode(",",array_keys($cols));
				$sql = "INSERT INTO {$table} ({$columns}) VALUES(".$positions.")";
				if (!$this->query($sql, array_values($cols), $table)->error()) {
					return $this;
				}
	}

	public function multiInsert($table, $rows = array())
	{
			end($rows);
			$lastRow = key($rows);
			$queryValues = "";
			$valuesArray = array();
			foreach ($rows as $key => $row) {
				end($row);
				$positions ="";
				$lastCol = key($row);
					foreach ($row as $k => $col) {
						$positions = $k==$lastCol? $positions." ? " : $positions." ?, ";
						$valuesArray[]=$col;
					}
				$queryValues = $key==$lastRow? $queryValues." (".$positions.")" : $queryValues." (".$positions."),";
			}	

			$columns = implode(", ",array_keys($rows[0]));
				$sql = "INSERT INTO {$table} ({$columns}) VALUES ".$queryValues;
				if (!$this->query($sql, $valuesArray, $table)->error()) {
					return $this;
				}
				return false;
	}

	public function update($table, $where = array(), $fields = array())
	{
			end($fields);
			$last = key($fields);
			$positions = "";
				foreach ($fields as $key => $col) {
					$positions = $key==$last? $positions." ".$key." = ? " :$positions." ".$key." = ?, ";
				}	
			$columns = implode(",",array_keys($fields));
				$whereId = $where['nombre'];
				$valWhereId = $where['valor'];
				$sql = "UPDATE {$table} SET {$positions} WHERE {$whereId} = '{$valWhereId}'";				

				if (!$this->query($sql, array_values($fields), "###")->error()) {
					return $this;
				}
				return false;
	}

	public function get($table, $where)
	{
		return $this->action("SELECT *",$table, $where);
	}
	
	public function action($action, $table, $where = array())
	{
		if (count($where) === 3) {
			$operators = array('=','>','<','>=','<=');
			
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";										
				if (!$this->query($sql, array($value),$table)->error()) {
					return $this;
				}
			}
		}
	}
/*
	Metodos 
*/
	protected function create($obj){	
		$t = $this->getTableName($obj);
		$c = $this->getColumns($obj);
		return $this->_db->insert($t,$c);
	}
	
	protected function delete($arg)
	{
		$id = "";
		if (is_object($arg)) {		
			$cols = $this->getColumns($arg);	
			if(in_array("id", $cols))
			{
				$id = $cols["id"];
			}
		}
			$id = $arg;
			$where = array($id, "=", $value);
			return $this->action("DELETE ",$table, $where);
	}
/*

*/

	protected function getTableName($obj){
		if ($obj)
		{
			return strtolower(get_class($obj));
		}
	}

	protected function getColumns($obj){
		if ($obj)
		{
			return strtolower(get_object_vars($obj));
		}
	}

/*

*/
	public function results()
	{
		return $this->_results;
	}

	public function first()
	{
		return $this->results()[0];
	}

	public function error()
	{
		return $this->_error;
	}

	public function count(){
		return $this->_count;
	}

}
	