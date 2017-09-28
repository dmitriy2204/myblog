<?php

namespace core;

class Validator implements ValidatorInterface
{
	public $schema;
	public $errors = [];
	public $clean = [];

	public function setSchema(array $schema)
	{
		$this->schema = $schema;
	}

	public function run(array $fields)
	{
		foreach ($this->schema as $name => $rules) {
			if(!isset($fields[$name]) && $rules['require']){
				$this->errors[$name] = 'Missed required parameter!';
			}

			if(isset($fields[$name])){
				if(empty($fields[$name])){
					$this->errors[$name] = sprintf('Поле %s не заполнено!', $rules['name']);
				}

				if(!is_string($fields[$name]) && $rules['type'] === 'string'){
					$this->errors[$name] = sprintf('Expected string value, %s given!', gettype($fields[$name]));
				}

				if(!is_numeric($fields[$name]) && $rules['type'] === 'integer'){
					$this->errors[$name] = sprintf('Expected integer value, %s given!', gettype($fields[$name]));
					echo "<pre>";
				}

				if(isset($rules['length'])){
					$strlen = strlen($fields[$name]);

					if(is_array($rules['length'])){
						$min = $rules['length'][0];
						$max = $rules['length'][1];
					}else{
						$min = 0;
						$max = $rules['length'];
					}

					if($strlen > $max){
						$this->errors[$name] = sprintf('Поле %s не должно быть длиннее %s символов, указано %s!', $rules['name'], $max, $strlen);
					}

					if($strlen < $min && $strlen > 0){
						$this->errors[$name] = sprintf('Поле %s не должно быть короче %s символов, указано %s!', $rules['name'], $min, $strlen);
					}
				}
			}
			
			if(!isset($this->errors[$name]) && isset($fields[$name])){
				$this->clean[$name] = trim(htmlspecialchars($fields[$name]));
			}
		}
	}


}