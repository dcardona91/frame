<?php
namespace ThisApp\Controllers;

use \ThisApp\Core\Controller;

/**
*
*/
class Chat {
	public function index($name = null)
	{
		$params = array(
			"title"=>"Chat test",
			"actualPage"=>"chat",
			"err"=>$name
		);

		$controller = new Controller;
		$controller->SendToView('chat.html',$params);
	}
}
