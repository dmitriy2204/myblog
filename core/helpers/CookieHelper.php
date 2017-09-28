<?php

namespace core\helpers;

class CookieHelper
{
	public static function set($name, $value, $time)
	{
		setcookie($name, $value, strtotime("+$time"));
	}

	public function get($name)
	{
		return $_COOKIE[$name] ?? false;
	}

	public static function del($name)
	{
		setcookie($name, '', time() -1);
	}
}