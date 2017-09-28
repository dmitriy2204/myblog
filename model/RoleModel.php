<?php

namespace model;

use core\DBDriverInterface;
use core\ValidatorInterface;
use core\DBDriver;

class RoleModel extends BaseModel
{
	public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
	{
		parent::__construct($db, $validator);
		$this->table = 'roles';
		$this->validator->setSchema([
			
			'id' => [
				'type' => 'integer',
				'require' => false
			],

			'name' => [
				'type' => 'string',
				'length' => [3, 20],
				'require' => true
			],

			'description' => [
				'type' => 'string',
				'length' => [15, 300],
				'require' => false
			]

		]);
	}

}