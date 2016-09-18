<?php

class Tiposdocumento
{
	public $_db;

# id, idIe, consSede, nombre, tel, direccion, comuna
	public  function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function get()
	{			
		return $this->_db->getAll("tiposdocumentos")->results();	
	}

}

