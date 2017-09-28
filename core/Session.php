<?php

namespace core;

class Session
{
	public function get($key)
	{
		return $_SESSION[$key] ?? null;
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function del($key)
	{
		unset($_SESSION[$key]);
	}
}