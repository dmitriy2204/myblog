<?php

namespace core;

use core\Request;
use core\Logger;
use core\ErrorHandler;
use core\Session;
use core\Cookie;
use core\Exception\PageNotFoundException;
use core\Exception\BaseException;
use controller\BaseController;
use controller\PublicController;
use core\ServiceContainer;
use core\providers\ModelProvider;
use core\providers\UserProvider;


class Application
{
	public $request;
	private $controller;
	private $action;
	private $container;

	public function __construct()
	{		
		$this->initRequest();
		$this->handlingUri();
		$this->container = new ServiceContainer();

		(new ModelProvider())->register($this->container);
		(new UserProvider())->register($this->container);
	}

	public function run()
	{
		try{
			if(!$this->controller){
				throw new PageNotFoundException();
			}
			$ctrl = new $this->controller($this->request, $this->container);
			$action = $this->action;

			$ctrl->$action();
			$ctrl->response();
		}catch(\PDOException $e){
			(
				new ErrorHandler(
					new PublicController($this->request, $this->container),
					new Logger('critical', LOG_DIR),
					DEV
				)	
			)->handle($e, 'Oooops... Something went wrong!');
		}catch(PageNotFoundException $e){
			(
				new ErrorHandler(
					new PublicController($this->request, $this->container),
					null,
					DEV
				)	
			)->handle($e, '404 error! Page not found!');
		}catch(BaseException $e){
			(
				new ErrorHandler(
					new PublicController($this->request, $this->container),
					new Logger('critical', LOG_DIR),
					DEV
				)	
			)->handle($e, 'Oooops... Something went wrong!');
		}
	}

	private function initRequest()
	{
		$this->request = new Request($_GET, $_POST, $_FILES, new Cookie(), $_SERVER, new Session());
	}

	private function handlingUri()
	{
		$arr = $this->getUriAsArr();
		$this->setIdFromUri($arr);
		$this->controller = $this->getController($arr);
		$this->action = $this->getAction($arr);
	}

	private function getUriAsArr()
		{
			$uri = explode('?', $this->request->getUri())[0];

			$uri = explode('/', $uri);
			$cnt = count($uri);

			if($uri[$cnt - 1] == ''){
				unset($uri[$cnt - 1]);
			}

			return $uri;
		}

	private function getController(array $uri)
	{
		$isAdmin = false;
		$controller = $uri[1] ?? DEFAULT_CONTROLLER;

		if($controller === 'admin'){
			$isAdmin = true;
			$controller = $uri[2] ?? DEFAULT_CONTROLLER;
		}

		switch($controller){
			case 'post':
				$controller = 'Post';					
			break;
			case 'user':
				$controller = 'User';
				break;
			default:
				$controller = false;
			break;
		}		

		if($isAdmin){
			$controller = "Admin{$controller}";
		}

		return $controller ? sprintf('controller\%sController', $controller) : false;

	}

	private function getAction(array $uri)
	{
		if($uri[1] === 'admin'){
			return $action = sprintf('%sAction', $uri[3] ?? 'index');
		}

		return $action = sprintf('%sAction', $uri[2] ?? 'index');
	}

	private function setIdFromUri(array $uri)
	{
		if($uri[1] === 'admin'){
			if(isset($uri[4])){
				$this->request->get['id'] = $uri[4];
			}
		}else{
			if(isset($uri[3])){
				$this->request->get['id'] = $uri[3];
			}
		}


		
	}

}
