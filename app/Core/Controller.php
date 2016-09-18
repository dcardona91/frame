<?php
namespace ThisApp\Core;

use \ThisApp\Aplication\System\Session;
use \ThisApp\Aplication\System\Config;
use \ThisApp\Aplication\Security\Token;

class Controller
{
	public function checkPost($values = array())
	{
		if(!Posts::check($values)){
			//$this->regresar();
			Redirect::to("busqueda");
		}
	}

	public function regresar()
	{
		Redirect::to("busqueda");
	}

	public function rol($rol)
	{
		Redirect::checkRol($rol ,"busqueda");
	}

	public function model($model){
		//require_once '../app/models/'.$model.'.php';
		$theModel = "ThisApp\Models\\".$model;
		return new $theModel;
	}

	public function sendToView($view, $data = [])
	{	
		//GENERALES PARA LA MASTER
		$flash = Session::getFlash();
		$path  = $this->model('Path')->get();
		$menu = "";
		$token = Token::create();
		if (Session::exists(Config::get("session/user_rol"))) {
			$menu  = $this->model('Menu')->get();
		}

		$masterParams = array(
			//"path"=>$path,
			"menus"=> $menu,
			"token" => $token,
			"flash" => $flash
			);

		//Session::exists(Config::get("session/session_name"))
		echo View::getInstance()->render(
			$view,
			array_merge($data, $masterParams)
			);	
	}
}