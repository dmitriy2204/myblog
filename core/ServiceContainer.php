<?php

namespace core;

class ServiceContainer
{
	private $container = [];

	public function register(string $name, \closure $service)
	{
		$this->container[$name] = $service;
	}

	public function get(string $name, array $params = [])
	{
		return call_user_func_array($this->container[$name], $params);
	}
}