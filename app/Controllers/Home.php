<?php
namespace ThisApp\Controllers;

use \ThisApp\Core\Controller;
use \ThisApp\Models\Test;
use \ThisApp\Models\Menu;

/**
*
*/
class Home {
	public function index($name = null)
	{
		$test = new Test();
		$menu = new Menu();

		$params = array(
			"title"=>"Bienvenido",
			"actualPage"=>"Home",
			"tests"=>$test->lists(),
			"menu"=>$menu->get(),
			"err"=>$name
		);

		$controller = new Controller;
		$controller->SendToView('home.html',$params);
	}
}
