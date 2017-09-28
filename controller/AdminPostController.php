<?php 

namespace controller;

use core\Request;
use core\ServiceContainer;
use core\Validator;
use model\PostModel;
use model\UserModel;
use model\RoleModel;
use model\PrivModel;
use model\SessionModel;
use core\User;

class AdminPostController extends AdminController
{
	public function indexAction()
	{	
		$posts = $this->container->get('model.post')->getAll();
		$users = $this->container->get('model.user')->getAll();

	    $this->title .= '::Главная';
		$this->content = $this->template('v_index_admin', ['posts' => $posts, 'users' => $users]);
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

	public function addAction()
	{
		$user = $this->container->get('service.user', [$this->request]);
		$mPosts = $this->container->get('model.post');
		/*if (!$user->can('add_article')) {
			die('Вы не авторизованы!');
		}*/
		//isAuth не работает

		$errors = [];

		if($this->request->isPost()){
			$title = $this->request->post['title'];
			$text = $this->request->post['text'];
			try{
				$mPosts->insert(
					[
						'title' => $title,
						'text' => $text
					]				
				);
				header('Location: ' . '/admin/');
				exit();
			}catch(ValidatorException $e){
				$errors = $e->getUnvalidFields();
			}
		}

		$this->title .= '::добавить статью';
		$this->content = $this->template('v_add', 
											[
												'action' => '/add', 
												'errors' => $errors, 
												'title' => $title, 
												'text' => $text
											]
										);

	}

	public function editAction()
	{
		$mPosts = $this->container->get('model.post');
		$id = (int)$this->request->get['id'];
		
		$articleInfo = $mPosts->get($id);
		$title = $articleInfo['title'];
		$text = $articleInfo['text'];
	
		if(isset($articleInfo['id'])){
			if($this->request->isPost()){
				$title = $this->request->post['title'];
				$text = $this->request->post['text'];
				$msg = '';
				
				if(empty($title) || empty($text)){
					$msg = 'Заполните все поля!';
				}else{
					try{
						$mPosts->edit($id,
							[
								'title' => $title,
								'text' => $text,
							]
						);
						header('Location: ' . '/admin/');
						exit();
					}catch(ValidatorException $e) {
	                    $msg = $e->getMessage();
	                }
					
				}
			}
		}else{
			$error404 = true;
		}	

		if($error404){
			$this->err404Action();
		}else{
			$this->title .= '::редактирование статьи';
			$this->content = $this->template('v_edit', 
												[
													'action' => '/edit',
													'title' => $title,
													'text' => $text,
													'msg' => $msg
												]
											);
		}	
	}

	public function delAction()
	{
		$mPosts = $this->container->get('model.post');
		$id = (int)$this->request->get['id'];
		

		if(isset($id) && $id != ''){
			$mPosts->del($id);

			header('Location: ' . '/admin/');
			exit();
		}
	}
}