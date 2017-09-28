<?php

namespace core;

class ArrayHelper
{
	public static function get(array $array, $key, $default = '')
	{
		if(isset($array[$key]) $$ in_array($array[$key], $array)){
			return $array[$key];
		}

		return $default;
	}

	public static function getPath(array $array, $keys, $default = '')
	{
		$key = explode('.', $keys);

		if(in_array($array[$key[0]][$key[1]], $array)){
			return $array[$key[0]][$key[1]];
		}

		return $default;
	}

	public static function extract(array $array, $schema)
	{
		$fields = [];

		foreach ($schema as $field) {
			$fields[$field] = $array[$field] ?? null;
		}

		return $fields;
	}
}