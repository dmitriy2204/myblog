<?php

/**
 * Проверка запроса
 */

namespace core;

class Request
{
	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';

	/**
	 * Глобальный массив $_GET
	 * @var array
	 */
	public $get;

	/**
	 * Глобальный массив $_POST
	 * @var array
	 */
	public $post;

	/**
	 * Глобальный массив $_FILES
	 * @var array
	 */
	public $files;

	/**
	 * Глобальный массив $_COOKIE
	 * @var array
	 */
	public $cookie;

	/**
	 * Глобальный массив $_SERVER
	 * @var array
	 */
	public $server;
	public $session;

	public function __construct($get, $post, $files, Cookie $cookie, $server, Session $session)
	{

		$this->get = $get;
		$this->post = $post;
		$this->files = $files;
		$this->cookie = $cookie;
		$this->server = $server;
		$this->session = $session;
	}

	/**
	 * Проверка захода на страницу методом POST
	 */
	public function isPost()
	{
		return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
	}

	/**
	 * Проверка захода на страницу методом GET
	 */
	public function isGet()
	{
		return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
	}

	/**
	 * Проверка существования параметра
	 */
	public function checkParam($param)
	{
		return isset($param) ? trim(htmlspecialchars($param)) : '';
	}

	public function getUri()
	{
		return $this->server['REQUEST_URI'];
	}

}