<?php 
namespace ThisApp\Aplication\System;
/**
* 
*/
class Session
{
	public static function exists($name)
	{
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function put($name, $value)
	{
		return $_SESSION[$name] = $value;
	}

	public static function get($name)
	{
		return $_SESSION[$name];
	}

	public static function setFlash($mensaje)
	{
		Self::put(Config::get("session/flash_msg"), $mensaje);
		return true;
	}

	public static function getFlash()
	{
		$flash = false;
		if(isset($_SESSION[Config::get("session/flash_msg")]))
		{
			$flash = $_SESSION[Config::get("session/flash_msg")];
			Self::delete(Config::get("session/flash_msg"));
		}
		return $flash;
	}


	public static function delete($name=null)
	{
		if (self::exists($name)) {
			unset($_SESSION[$name]);
		}
		//session_destroy();
	}

	public static function destroy()
	{
		session_destroy();
	}

	public static function flash($name, $string = "")
	{
		if (self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;
		}else{
			self::put($name, $string);
		}
	}
}
