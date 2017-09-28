<?php

namespace core\exception;

class PageNotFoundException extends BaseException
{
	public function __construct($message = "404 error", $code = 404, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}