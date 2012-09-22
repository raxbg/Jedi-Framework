<?php

class System
{
	private $loadClass;
	
	private $controllers;
	
	private $models;
	
	private $cache;
	
	private $data;
	
	private $dbConnected;
	
	public function System()
	{
		global $data;
		
		$this->controllers = array();
		$this->models = array();
		$this->loadClass = new Load();
		$this->data = $data;
		$this->dbConnected = false;
	}
	
	public function controllersArrayPush($controller)
	{
		$name = strtolower(get_class($controller));
		$this->controllers[$name] = $controller;
	}
	
	public function modelsArrayPush($model)
	{
		$name = strtolower(get_class($model));
		$this->controllers[$name] = $model;
	}
	
	public function setCache($cache)
	{
		if( is_object($cache) )
			$this->cache = $cache;
		else
			return false;
		return true;
	}
	
	public function controller($name)
	{
		$name = strtolower($name);
		return $this->controllers[$name];
	}
	
	public function model($name)
	{
		$name = strtolower($name);
		return $this->models[$name];
	}
	
	public function load()
	{
		return $this->loadClass;
	}
	
	public function cache()
	{
		return $this->cache;
	}
	
	public function data()
	{
		return $this->data;
	}
	
	public function registerDbConnect()
	{
		$this->dbConnected = true;
	}
	
	public function unregisterDbConnection()
	{
		$this->dbConnected = false;
	}
	
	public function hasDbConnection()
	{
		return (bool)$this->dbConnected;
	}
}
