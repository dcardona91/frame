<?php 
namespace ThisApp\Aplication\Security;

use \ThisApp\Aplication\System\Session;
use \ThisApp\Aplication\System\Config;
/**
* 
*/
class Token
{
	
	public static function create()
	{
		return Session::put(Config::get("session/token_name"), sha1(uniqid()));
	}

	public static function validate($token){		
		$tokenName = Config::get("session/token_name");

		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
		return false;
	}
}
 ?>