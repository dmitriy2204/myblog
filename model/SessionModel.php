<?php

namespace model;

use core\DBDriver;
use core\DBDriverInterface;
use core\ValidatorInterface;

class SessionModel extends BaseModel
{

	public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
	{
		parent::__construct($db, $validator);
		$this->table = 'session';
		$this->id = 'id';
		$this->validator->setSchema([
			'id' => [
				'type' => 'integer',
				'require' => false
			],

			'sid' => [
				'type' => 'string',
				'length' => 16,
				'require' => true
			],

			'created_at' => [
				'type' => 'string',
				'require' => false
			],

			'updated_at' => [
				'type' => 'string',
				'require' => false
			],

			'user_id' => [
				'type' => 'integer',
				'require' => true
			]
		]);
	}

	public function setSessionParam ($param, $value)
    {
        return $_SESSION[$param] = $value;
    }

	public function getSession($sid)
    {
        $session = $this->db->Query("SELECT * FROM {$this->table} WHERE sid = :sid", 
        								[
        									'sid' => $sid
        								]
        							);
        
        return !empty($session) ? $session[0] : false;
    }

    
}	