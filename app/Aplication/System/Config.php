<?php
namespace ThisApp\Aplication\System;

class Config{
/**
 * @type array
 */
	private static $globals = array(
			'mysql' => array(
				'host' =>  'localhost',
				'username'=> 'root',
				'password' => '',
				'db' => 'ajseguros'
				),
			'remember' => array(
				'cookie_name' => 'hash',
				'cookie_expiry' => 604800
				),
			'session' => array(
				'session_name' => 'user',
				'token_name' => 'token',
				'user_name' => 'name',
				'user_rol' => 'rol',
				'user_mail' => 'mail',
				"flash_msg" => 'flash'
				)
			);

	public static function get($path = null){
		if ($path) {
			$config = self::$globals;
			$path = explode('/', $path);
			foreach ($path as $bit) {
				if (isset($config[$bit])) {
					$config = $config[$bit];
				}
			}
			return $config;
		}

		return false;
	}
}
