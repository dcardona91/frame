<?php
namespace ThisApp\Models;

use \ThisApp\Aplication\System\DB;
use \ThisApp\Aplication\System\Session;
use \ThisApp\Aplication\System\Config;


class Menu 
{
	public function __construct(){
		Session::put("rol",1);
	}

	public function get()
	{
		$rol = Session::get(Config::get("session/user_rol"));
		$query = "SELECT 
				id,
				CONCAT(nombre,'~',url,'~',ifnull(tooltip,''),'~',ifnull(tienda,'0'),'~',ifnull(icono,'0')) as nombre,
				titulo, 
				url, 
				tooltip, 
				padre, 
				orden,
				icono,
				activo,
				sistema,
				tienda
				FROM menus WHERE activo = 1 and id in (select idMenu from menus_x_rol where idRol = {$rol}) and padre = 0 order by orden ASC;";	
		return $this->menuMaker($this->query($query));
	}

	public function getChilds($parent)
	{
		return $this->query("menus",array("padre","=",$parent));	
	}

	private function query($query, $params = array() )
	{
		if(count($params)> 0)
			$result = DB::getInstance()->get($query, $params);
		else
			$result = DB::getInstance()->query($query);	
		return !$result->count() ? '0': $result->results();
	}


	private function menuMaker($menuItems = array())
	{

	$f_nombre = "";
	$f_url = "";
	$f_tooltip = "";
	$f_padre = "";
	$f_icono = "";
	$f_tienda = "";

		$menuCompleto = array();		
			foreach ($menuItems as $row => $cols) {	
				foreach ($cols as $colName => $colValue) {
					switch ($colName) {
									case 'id':
										$f_id = $colValue;
										break;								
									case 'nombre':
										$f_nombre = $colValue;
										break;							
									case 'url':
										$f_url = $colValue;
										break;
									case 'tooltip':
										$f_tooltip = $colValue;
										break;
									case 'padre':
										$f_padre = $colValue;
										break;								
									case 'icono':
										$f_icono = $colValue;
										break;
									case 'tienda':
										$f_tienda = $colValue;
										break;
								}			
				}
				if ($f_padre == 0) {				
					$rpta = $this->getChilds($f_id);
					if ($rpta != 0) {
						$subMenus = $this->menuMaker($rpta);
						$menuCompleto[$f_nombre] = $subMenus;
					}
					else
					{
						$menuCompleto[$f_nombre] = NULL;
					}		
				}
				else
				{
					$menuCompleto[$f_nombre] = array(
					"nombre"=> $f_nombre ,
					"url"=> $f_url ,
					"tooltip"=> $f_tooltip ,
					"padre"=> $f_padre ,
					"icono"=> $f_icono ,
					"tienda"=> $f_tienda 
					);
				}		
			}	
			return $menuCompleto;
	} 
}