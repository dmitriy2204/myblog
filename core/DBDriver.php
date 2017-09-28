<?php

/**
 * Драйвер для работы с БД
 */

namespace core;

class DBDriver implements DBDriverInterface
{
	const FETCH_ONE = 0;
	const FETCH_All = 1;

	private $pdo;

	/**
	 * DBDriver конструктор
	 * @param \PDO $pdo
	 */
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Универсальная выборка из БД
	 * @param string $sql
	 * @param array $params
	 *
	 * return array
	 */
	public function Query($sql, array $params = [], $fetch = self::FETCH_All)
	{
		$query = $this->pdo->prepare($sql);
		$query->execute($params);

		return $fetch === self::FETCH_All ? $query->fetchAll() : $query->fetch();
	} 
 
	/** 
	 * Добавление в таблицу $table значений массива $obj
	 * @param string $table
	 * @param array $obj
	 *
	 * return int идентификатор вставленной записи
	 */
	public function Insert($table, array $obj)
	{
		$columns = [];
		$masks = [];

		foreach ($obj as $key => $value) {
			$columns[] = $key;
			$masks[] = ":$key";

			if($value === null){
				$obj[$key] = 'NULL';
			}
		}

		$fields = implode(',', $columns); //title, text
		$values = implode(',', $masks); //:title, :text

		try{
			$sql = "INSERT INTO $table ($fields) VALUES ($values)";
			$query = $this->pdo->prepare($sql);
			$query->execute($obj);
			$res = $this->pdo->lastInsertId(); 
		}catch(\PDOException $e){
			die('Failed connection to BD' . '<br>' . 'Trace: ' . $e->getTraceAsString());
		}

		return $res;
	}

	/**
	 * Изменение полей в таблице $table значениями массива $obj с условием $where
	 * @param string $table
	 * @param array $obj
	 * @param string $where
	 * @param array $params
	 *
	 * return int количество измененных строк
	 */
	public function Update($table, array $obj, $where, $params = [])
	{
		$pairs = [];

		foreach ($obj as $key => $value) {
			$pairs[] = "$key=:$key";

			if($value === NULL){
				$obj[$key] = 'NULL';
			}
		}

		$pairs_str = implode(',', $pairs);

		try{
			$sql = "UPDATE $table SET $pairs_str WHERE $where";
			$merge = array_merge($obj, $params);
			$query = $this->pdo->prepare($sql);
			$query->execute($merge);
			$res = $query->rowCount();	
		}catch(\PDOException $e){
			die('Failed connection to BD' . '<br>' . 'Trace: ' . $e->getTraceAsString());
		}
	
		return $res;
	}

	/**
	 * Удаление записи из таблицы $table по идентификатору
	 * @param string $table
	 * @param string $where
	 * @param array $params
	 *
	 * return int количество измененных строк
	 */
	public function Delete($table, $where, $params = [])
	{
		try{
			$sql = "DELETE FROM $table WHERE $where";
			$query = $this->pdo->prepare($sql);
			$query->execute($params);
			$res = $query->rowCount();
		}catch(\PDOException $e){
			die('Failed connection to BD' . '<br>' . 'Trace: ' . $e->getTraceAsString());
		}

		return $res;
	}
}