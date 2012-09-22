<?php
class Controller
{
	private $jsArray;
	
	private $cssArray;
	
	private $uri;
	
	private $controller;
	
	private $data;
	
	public function Controller($readyUri = false)
	{
		global $system;
		
		$this->jsArray = array();
		$this->cssArray = array();
		$this->data = $system->data();
	}
	
	protected function addJs($jsFile)
	{
		$this->jsArray[] = $jsFile;
	}
	
	protected function addCss($cssFile)
	{
		$this->cssArray[] = $cssFile;
	}
	
	protected function displayView($name, $args = false)
	{
		if( !empty($args) )
		{
			if( $this->data()->validate()->isAssociativeArray($args) )
			{
				foreach( $args as $varName=>$value )
				{
					${$varName} = $value;
				}
			}
		}
		
		include VIEWS_DIR.DS.$name.'.php';
	}
	
	protected function data()
	{
		return $this->data;
	}
	
	protected function processData()
	{
		//process some kind of incomming data
	}
	
	protected function header()
	{
		//put stuff in the header
	}
	
	protected function open()
	{
		//the main content
	}
}
