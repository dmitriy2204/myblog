<?php

/**
 * Базовый контроллер
 */

namespace controller;

use core\Request;
use core\exception\PageNotFoundException;
use core\ServiceContainer;

abstract class BaseController
{
	protected $title;
	protected $content;
	protected $request;
	protected $container;
	
	public function __construct(Request $request, ServiceContainer $container)
	{
		$this->title = 'PHP.blog';
		$this->content = '';
		$this->request = $request;
		$this->container = $container;
	}

	public function __call($name, $args)
	{
		throw new PageNotFoundException();
	}

	public function staticAction($message)
	{
		$this->content = $message;
	}

	/**
	 * Выводит на экран сгенерированный шаблон
	 * Переопределяется в наследнике с использованием метода template()
	 */
	abstract public function response();

	/**
	 * Подставляет переменные в шаблон
	 * @param string $tmp - шаблон
	 * @param array $vars - переменные для шаблона
	 * @return string - сгенерированный шаблон
	 */
	protected function template($tmp, $vars = [])
	{
        extract($vars);
        ob_start();

        include_once("view/$tmp.php");

        return ob_get_clean();
    }

    public function err404Action()
    {
    	$this->title = 'Ошибка 404';
    	$this->content = $this->template('v_404');
    	header("HTTP/1.1 404 Not Found");
    }
}    