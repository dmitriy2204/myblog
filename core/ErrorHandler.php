<?php

namespace core;
use controller\PublicController;
use core\Logger;

class ErrorHandler implements ErrorHandlerInterface
{
	private $ctrl;
	private $logger;
	private $dev;

	public function __construct(PublicController $ctrl, Logger $logger = null, $dev = true)
	{
		$this->ctrl = $ctrl;
		$this->logger = $logger;
		$this->dev = $dev;
	}

	public function handle(\Exception $e, $message)
	{
		if(isset($this->logger)){
			$this->logger->write(sprintf("%s\n%s", $e->getMessage(), $e->getTraceAsString()), 'ERROR');
		}

		$msg = sprintf('<h1>%s</h1>', $message);

		if($this->dev){
			$msg = sprintf('%s<h2>%s</h2><p>%s</p>', $msg, $e->getMessage(), $e->getTraceAsString());
		}

		$this->ctrl->staticAction($msg);
		$this->ctrl->response();
		
	}
}