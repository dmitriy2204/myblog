<?php

/**
 * Интерфейс драйвера работы с БД
 */

namespace core;

interface DBDriverInterface
{
	/**
	 * DBDriverInterface конструктор 
	 * @param \PDO $pdo
	 */
	public function __construct(\PDO $pdo); //сигнатура метода - какие параметры принимает

	/**
	 * Универсальный запрос к БД
	 * @param string $sql
	 * @return array | integer
	 */
	public function Query($sql, array $params, $fetch);

	/**
	 * Вставка в таблицу $table
	 * @param string $table
	 * @param array $obj 
	 * @return integer идентификатор вставленной записи
	 */
	public function Insert($table, array $obj);

	/**
	 * Обновить информацию в строке таблицы
	 * @param string $table 
	 * @param array $obj 
	 * @param string where
	 * @return integer количество измененных строк
	 */
	public function Update($table, array $obj, $where, $params);

	/**
	 * delete from table
	 * @param string $table 
	 * @return string where
	 * @return integer количество измененных строк
	 */
	public function Delete($table, $where, $params);

}

