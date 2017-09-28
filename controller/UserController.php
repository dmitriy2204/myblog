<?php

/**
 * Контроллер пользователей
 */

namespace controller;

use controller\BaseController;
use model\UserModel;
use model\RoleModel;
use model\PrivModel;
use core\User;
use model\Auth;
use model\SessionModel;
use core\DB;
use core\DBDriver;
use core\Request;
use core\Core;
use core\Validator;
use core\exception\ValidatorException;
use core\exception\UserException;
use core\ServiceContainer;

class UserController extends PublicController
{	
	public function addAction()
	{
		$user = $this->container->get('service.user', [$this->request]);
		$errors = [];
		$message = '';
		if($this->request->isPost()){
			try{
				$user->registration();
				header('Location: ' . '/');
				exit();
			}catch(UserException $e){
				$errors = $e->getUnvalidFields();
				$message = $e->getMessage();
			}
		}

		$this->title .= '::регистрация';
		$this->content = $this->template('v_registration', [
				'errors' => $errors,
				'post' => $this->request->post,
				'message' => $message
			]);	
	}

	public function loginAction()
	{
		$errors = [];
		$message = '';
		
		if($this->request->isPost()){
			try{
				$user = $this->container->get('service.user', [$this->request]);
				$user->login();
				$userLogin = $this->request->post['login'];

				if($userLogin === 'admin'){
					header('Location: ' . '/admin/');
					exit();
				}

				header('Location: ' . '/');
				exit();
			}catch(UserException $e){
				$errors = $e->getUnvalidFields();
				$message = $e->getMessage(); 
			}
		}

		$this->title .= '::войти';
		$this->content = $this->template('v_login', [
				'errors' => $errors,
				'post' => $this->request->post,
				'message' => $message
			]);

	}

}
