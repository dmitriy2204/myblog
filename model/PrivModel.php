<?php

namespace model;

use core\DBDriverInterface;
use core\ValidatorInterface;
use core\DBDriver;

class PrivModel extends BaseModel
{
	public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
	{
		parent::__construct($db, $validator);
		$this->table = 'privs';
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

	public function getUserByPrivAndLogin(string $privName, string $login)
	{
		return $this->db->query(
			"SELECT login, privs.name as priv_name FROM {$this->table} 
			 JOIN privs_to_roles ON privs.id = privs_to_roles.id_priv
			 JOIN users ON privs_to_roles.id_role = users.id_role
			 WHERE users.login = :login AND privs.name = :priv_name",
			 [
			 	'login' => $login,
			 	'priv_name' => $privName
			 ],
			 DBDriver::FETCH_ONE
			);
	}

}