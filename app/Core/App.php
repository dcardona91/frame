<?php
namespace ThisApp\Core;
#llamar las instancias

use Illuminate\Http\Request;

class App
{
	protected $controller = 'Home';
	protected $method = 'index';
	protected $params = [];

	public function __construct()
	{
		$url = $this->getUrl();

		if(file_exists('../app/Controllers/'.ucfirst(strtolower($url[0])).'.php'))
		{
			$this->controller = ucfirst(strtolower($url[0]));
			unset($url[0]);
		}

		//require_once '../app/controllers/'.$this->controller.'.php';

		$theController = "ThisApp\Controllers\\".$this->controller;
		$this->controller = new $theController;

		if (isset($url[1]))
		{
			if (method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}
		}

		$this->params = $url ? array_values($url) : [];


		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	public function getUrl()
	{
		$url = Request::capture()->getRequestUri();
		//echo $url;
		return $url = explode('/', filter_var(trim($url,'/'),FILTER_SANITIZE_URL));
	}
}
