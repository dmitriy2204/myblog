<?php

/**
 * Подключение к БД
 */

namespace core;

class DB
{
	private static $instance;

	public static function get()
	{
		if(self::$instance === null){
			self::$instance = self::connect();
		}

		return self::$instance;
	}

/*
	public function get() //Альтернатива
	{
		return !(static::$instance instanceof self) ? static::$instance = new self() : static::$instance;
	}
*/

	private static function connect()
	{
		$dsn = DB_DRIVER . ':' . 'host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
		$opt = [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		];
		$pdo = new \PDO($dsn, DB_LOGIN, DB_PASS, $opt);

		return $pdo;
	}
}