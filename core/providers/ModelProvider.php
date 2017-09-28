<?php
/**
 * Регистрация всех моделей
 */

namespace core\providers;

use core\ServiceContainer;
use model\PostModel;
use model\UserModel;
use model\SessionModel;
use model\RoleModel;
use model\PrivModel;
use core\DB;
use core\DBDriver;
use core\Validator;

class ModelProvider
{
	public function register(ServiceContainer &$container)
	{
		$driver = new DBDriver(DB::get());
		$validator = new Validator();

		$container->register('model.post', function() use ($driver){
			return new PostModel(
				$driver, 
				$validator = new Validator()
			);
		});

		$container->register('model.user', function() use ($driver){
			return new UserModel(
				$driver, 
				$validator = new Validator()
			);
		});

		$container->register('model.session', function() use ($driver){
			return new SessionModel(
				$driver, 
				$validator = new Validator()
			);
		});

		$container->register('model.privs', function() use ($driver){
			return new PrivModel(
				$driver, 
				$validator = new Validator()
			);
		});

		$container->register('model.roles', function() use ($driver){
			return new RoleModel(
				$driver, 
				$validator = new Validator()
			);
		});
	}
	
}