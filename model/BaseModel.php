<?php

/**
 * Базовая модель
 */

namespace model;

use core\DBDriverInterface;
use core\exception\ModelException;
use core\exception\ValidatorException;
use core\ValidatorInterface;

abstract class BaseModel
{
	/**
	 * @var DBDriverInterface
	 */
	protected $db;
	
	/**
	 * Название таблицы
	 * @var string
	 */

	protected $validator;

	protected $table = false;

	/**
	 * BaseModel конструктор
	 * @param DBDriverInterface $db
	 */

	/**
	 * Идентификатор
	 * @var int
	 */
	protected $id;

	public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
	{
		$this->db = $db;
		$this->validator = $validator;
	
	}

	/**
	 * Выборка всех полей из таблицы $this->table
	 * return array массив полей
	 */
	public function getAll()
	{
		return $this->db->Query("SELECT * FROM {$this->table} ORDER BY dt DESC");
	}

	/**
	 * Выборка полей из таблицы $this->table по идентификатору 
	 * @param int $id
	 * @return array|false
	 */
	public function get($id)
	{
		$res = $this->db->Query("SELECT * FROM {$this->table} WHERE {$this->id} = :id LIMIT 1", ['id' => $id]);
		return !empty($res[0]) ? $res[0] : false;
	}

	/**
	 * Вставка полей в таблицы $this->table
	 * @param array $fields
	 * return true|false
	 */
	public function insert(array $fields)
	{	
		$this->validator->run($fields);
		
		if(!empty($this->validator->errors)){
			throw new ValidatorException($this->validator->errors);		
		}
		
		return $this->db->Insert($this->table, $this->validator->clean);
	}

	/**
	 * Редактирование одной записи в таблице $this->table по идентификатору
	 * @param int $id 
	 * @param array $obj
	 * return true|false
	 */
	public function edit($id, array $fields)
	{
		$this->validator->run($fields);

		if(!empty($this->validator->errors)){
			throw new ValidatorException($this->validator->errors);
		}else{
			return $this->db->Update("$this->table", $fields, "{$this->id}=:id", ['id' => $id]);
		}
	}

	/**
	 * Удаление записи из таблицы $this->table по идентификатору
	 * @param int $id
	 * return true|false
	 */
	public function del($id)
	{
		return $this->db->Delete($this->table, "{$this->id}=:id", ['id' => $id]);
	}

}	