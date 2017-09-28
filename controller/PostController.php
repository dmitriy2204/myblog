<?php

/**
 * Контроллер статей
 */

namespace controller;

use model\PostModel;
use model\UserModel;
use model\RoleModel;
use model\PrivModel;
use model\SessionModel;
use core\DB;
use core\DBDriver;
use core\Request;
use core\Validator;
use core\exception\ValidatorException;
use core\exception\PageNotFoundException;
use core\User;

class PostController extends PublicController
{
	public function indexAction()
	{	
		$posts = $this->container->get('model.post')->getAll();

	    $this->title .= '::Главная';
		$this->content = $this->template('v_index', ['posts' => $posts]);
	}

	public function oneAction()
	{
		$mPosts = $this->container->get('model.post');
		$id = $this->request->get['id'];
		if(!preg_match("/^[0-9]+$/", $id)){
			throw new PageNotFoundException();
		}

	  	
		$article = $mPosts->get($id);
		if(!$article){
			throw new PageNotFoundException();
		}	
		$this->title .= "::Просмотр статьи";
		$this->content = $this->template('v_post', ['article' => $article]);
	}
}    