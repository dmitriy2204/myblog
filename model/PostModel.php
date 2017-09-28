<?php

/**
 * Модель статей
 */

namespace model;

use core\DBDriverInterface;
use core\ValidatorInterface;

class PostModel extends BaseModel
{
	/**
	 * PostModel конструктор
	 * @param DBDriverInterface $db
	 */
	public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
	{
		parent::__construct($db, $validator);
		$this->table = 'articles';
		$this->id = 'id';
		$this->validator->setSchema([
			'id' => [
				'type' => 'integer',
				'require' => false
			],

			'dt' => [
				'type' => 'string',
				'require' => false
			],

			'title' => [
				'type' => 'string',
				'length' => [5, 50],
				'name' => '"Заголовок статьи"',
				'require' => true
			],

			'text' => [
				'type' => 'string',
				'name' => '"Текст статьи"',
				'require' => true
			], 

			'image' => [
				'type' => 'string',
				'length' => '155',
				'require' => false
			]
		]);
	}
}	