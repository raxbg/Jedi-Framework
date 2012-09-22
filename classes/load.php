<?php

class Load
{
	public function Load(){}
	
	public function controller($controllerName)
	{
		global $system;
		$controllerName = ucfirst(strtolower($controllerName));
		$system->controllersArrayPush(new $controllerName());
	}
	
	public function model($modelName)
	{
		global $system;
		$modelName = ucfirst(strtolower($modelName));
	}
	
	public function cacheFile($filename)
	{
		global $system;
		$cache = new Cache($filename);
		$system->setCache($cache);
	}
}
