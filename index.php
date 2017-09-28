<?php
	session_start();
	include_once('config.php');
	include_once('model/UserModel.php');
	include_once('core/User.php');

	function __autoload($classname){
		$fileName = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
		if (!file_exists($fileName)) {
			var_dump($fileName);
			die;
		}
		include_once $fileName;
	}

	$app = new core\Application();

	$app->run();

