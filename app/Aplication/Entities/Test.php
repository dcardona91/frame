<?php
namespace ThisApp\Aplication\Entities;

use \ThisApp\Aplication\System\DB;

class Test
{
	private $id,
			$nombre,
			$correo;
	
	function __construct($nombre, $correo)
	{
		$this->nombre = $nombre;
		$this->correo = $correo;
	}

	public function setName($nombre){
		$this->$nombre = $nombre;
	}

	public function setCorreo($correo){
		$this->$correo = $correo;
	}

	public function getName(){
		return $this->$nombre;
	}

	public function getCorreo(){
		return $this->$correo;
	}

	
}