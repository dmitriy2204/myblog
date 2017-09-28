<?php

namespace core;

use model\UserModel;
use model\SessionModel;
use model\RoleModel;
use model\PrivModel;
use core\exception\UserException;
use core\exception\ValidatorException;
use core\helpers\CookieHelper;
use core\Request;

class User
{
	private $mUser;
	private $mSession;
	private $request;
	private $mRole;
	private $mPriv;

	public function __construct(
		Request $request, 
		UserModel $mUser, 
		SessionModel $mSession,
		RoleModel $mRole,
		PrivModel $mPriv
	)
	{
		$this->request = $request;
		$this->mUser = $mUser;
		$this->mSession = $mSession;
		$this->mRole = $mRole;
		$this->mPriv = $mPriv;	
	}

	public function registration()
	{
		$user = $this->mUser->getByLogin($this->request->post['login']);
		if(!empty($user)){
			throw new UserException([], sprintf('Пользователь с логином %s уже существует!', $this->request->post['login']));
		}

		$login = $this->request->post['login'];
		$email = $this->request->post['email'];
		$password = $this->myCrypt($this->request->post['password']);
		$password2 = $this->myCrypt($this->request->post['password2']);

		if($password !== $password2){
			throw new UserException([], 'Повторный пароль введен неверно!');
		}

		try{
			return $this->mUser->insert(['login' => $login, 'password' => $password, 'email' => $email]); 
		}catch(ValidatorException $e){
			throw new UserException($e->getUnvalidFields(), $e->getMessage(), $e->getCode(), $e);
		}
	}

	public function login()
	{
		$user = $this->mUser->getByLogin($this->request->post['login']);

		if(empty($user)){
			throw new UserException([], sprintf('Пользователь с логином %s не существует!', $this->request->post['login']));
		}

		if($this->myCrypt($this->request->post['password']) !== $user['password']){
			throw new UserException([], 'Неправильный логин или пароль!');
		}

		$sid = $this->getToken(); //Генерация sid

		$this->request->session->set('sid', $sid);
		$this->mSession->insert(['sid' => $sid, 'user_id' => $user['id']]);

		if(isset($this->request->post['remember'])){
			$this->request->cookie->set('user', $this->request->post['login'], '30 days');
		}

		return true;
	}

	private function getToken()
	{
		$pattern = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
		$token = '';

		for($i = 0; $i < TOKEN_LENGTH; $i++){
			$symbol_num = mt_rand(0, strlen($pattern) - 1);
			$token .= $pattern[$symbol_num];
		}

		return $token;
	}

	public function checkAuth()
	{
		$result = false;
		$sid = $this->request->session->get('sid');
		$cookieLogin = $this->request->cookie->get('user');

		if(!$sid && !$cookieLogin){
			return false;
		}

		if($sid){
			$result = $this->mUser->getBySid($sid);
		}

		if($result){
			$this->mSession->edit($result['user_id'], ['updated_at' => date("Y-m-d H:i:s", time())]); //большая проблема
			return $result;
		}

		if($cookieLogin){
			$result = $this->mUser->getByLogin($cookieLogin);
		}

		if($result){
			$sid = $this->getToken(); 

			$this->request->session->set('sid', $sid);
			$this->mSession->insert(['sid' => $sid, 'user_id' => $result['user_id']]);
		}
		
		return $result;
	}

	public function can(string $priv)
	{
		if (!$user = $this->checkAuth()) {
			return false;
		}

		$login = $user['login'];
		$user = $this->mPriv->getUserByPrivAndLogin($priv, $login);

		return !empty($user);
	}
	
	private function myCrypt($str)
	{
		return hash('sha256', $str . SAULT);
	}

}