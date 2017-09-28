<?php

namespace controller;

use controller\BaseController;
use model\UserModel;
use model\RoleModel;
use model\PrivModel;
use core\User;
use model\SessionModel;
use core\DB;
use core\DBDriver;
use core\Request;
use core\Core;
use core\Validator;
use core\exception\ValidatorException;
use core\exception\UserException;
use core\ServiceContainer;

class AdminUserController extends AdminController
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

	public function delAction()
	{
		$user = $this->container->get('model.user');
		$id = (int)$this->request->get['id'];
		

		if(isset($id) && $id != ''){
			$user->del($id);

			header('Location: ' . '/admin/');
			exit();
		}
	}
}