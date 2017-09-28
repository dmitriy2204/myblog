<?php

namespace model;

use core\DBDriverInterface;
use core\DBDriver;
use core\ValidatorInterface;

class UserModel extends BaseModel
{

	public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
	{
		parent::__construct($db, $validator);
		$this->table = 'users';
		$this->id = 'id';
		$this->validator->setSchema([
			'id' => [
				'type' => 'integer',
				'require' => false
			],

			'reg_date' => [
				'type' => 'string',
				'require' => false
			],

			'login' => [
				'type' => 'string',
				'length' => [3, 20],
				'name' => '"Логин"',
				'require' => true
			],

			'email' => [
				'type' => 'string',
				'length' => [10, 50],
				'name' => '"email"',
				'require' => true
			],

			'password' => [
				'type' => 'string',
				'length' => 64,
				'name' => '"Пароль"',
				'require' => true
			], 

			'id_role' => [
				'type' => 'string',
				'require' => false
			]

		]);
	}

	public function getAll()
	{
		return $this->db->Query("SELECT * FROM {$this->table} ORDER BY id DESC");
	}

	public function getByLogin($login)
	{
		return $this->db->query("SELECT * FROM {$this->table} WHERE login = :login",
				['login' => $login],
				DBDriver::FETCH_ONE
			);
	}

	public function getBySid($sid)
	{
		return $this->db->query(
				"SELECT * FROM {$this->table} JOIN session ON {$this->table}.id = session.user_id WHERE session.sid = :sid", 
					['sid' => $sid], 
					DBDriver::FETCH_ONE
			);
	}

	public function findPriv($id, $privs_name)
	{
		return $this->db->query("SELECT login, roles.name as role_name, privs.name as priv_name
									FROM {$this->table}
									JOIN roles
									ON {$this->table}.id_role = roles.id
									JOIN privs_to_roles
									ON roles.id = privs_to_roles.id_role
									JOIN privs
									ON privs.id = privs_to_roles.id_priv
									WHERE {$this->table}.id = :id AND privs.name = :privs_name",
									['id' => $id, 'privs_name' => $privs_name],
									DBDriver::FETCH_ONE
								);
	}
}	