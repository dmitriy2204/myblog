<?php

namespace core;
use controller\PublicController;
use core\Logger;

interface ErrorHandlerInterface
{
	/**
	 * $ctrl контроллер
	 * $logger логгер
	 * $dev переключатель режима разработчик/пользователь
	 */
	public function __construct(PublicController $ctrl, Logger $logger = null, $dev = true);

	public function handle(\Exception $e, $message); 
}