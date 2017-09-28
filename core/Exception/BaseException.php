<?php

namespace core\exception;

class BaseException extends \Exception
{
	public function __construct($message = "Critical Exception", $code = 500, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}