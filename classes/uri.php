<?php

class Uri
{
	private $request_uri;
	
	private $parsedUri;
	
	public function Uri()
	{
		$this->request_uri = rtrim($_SERVER['REQUEST_URI'],'/');
		$this->parseUri();
	}
	
	public function parseUri($uri = false)
	{
		if( !$uri )
		{
			$requestParams = substr($_SERVER['PHP_SELF'],strpos($_SERVER['PHP_SELF'],basename($_SERVER['SCRIPT_NAME']))+strlen(basename($_SERVER['SCRIPT_NAME'])));
			$requestParams = rtrim($requestParams, '/');
			$this->parsedUri = !empty($requestParams) ? explode('/',trim($requestParams,'/')) : array();
		}
		else
		{
			//regexp to match the filename then do whatever should be done
			//$requestParams = substr($url,strpos($_SERVER['PHP_SELF'],basename($_SERVER['SCRIPT_NAME']))+strlen(basename($_SERVER['SCRIPT_NAME'])));
			//$this->parsedUrl = explode('/',trim($requestParams,'/'));
		}
	}
	
	public function getParam($paramNumber)
	{
		return $this->parsedUri[$paramNumber-1];
	}
	
	public function fullUri()
	{
		return $this->request_uri;
	}
	
	public function size()
	{
		return count($this->parsedUri);
	}
}
