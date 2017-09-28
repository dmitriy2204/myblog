<?php

namespace core\exception;

class UserException extends BaseException
{
	private $unvalidFields = [];

	public function __construct(array $unvalid = [], $message = "User Exception", $code = 403, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->unvalidFields = $unvalid;
	}

	public function getUnvalidFields()
	{
		return $this->unvalidFields;
	}
}