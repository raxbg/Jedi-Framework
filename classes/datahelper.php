<?php
class DataHelper
{
	private $mixVar;
	
	public function setVar($newValue)
	{
		$this->mixVar = $newValue;
	}
	
	public function isInt()
	{
		global $system;
		
		return $system->data()->validate()->isInt($this->mixVar);
	}
	
	public function isFloat()
	{
		global $system;
		
		return $system->data()->validate()->isFloat($this->mixVar);
	}
	
	public function isDouble()
	{
		global $system;
		
		return $system->data()->validate()->isDouble($this->mixVar);
	}
	
	public function isAssociativeArray()
	{
		global $system;
		
		return $system->data()->validate()->isAssociativeArray($this->mixVar);
	}
	
	public function isArray()
	{
		global $system;
		
		return $system->data()->validate()->isArray($this->mixVar);
	}
	
	public function parseInt()
	{
		global $system;
		
		return $system->data()->parseInt($this->mixVar);
	}
	
	public function parseFloat()
	{
		global $system;
		
		return $system->data()->parseFloat($this->mixVar);
	}
	
	public function parseDouble()
	{
		global $system;
		
		return $system->data()->parseDouble($this->mixVar);
	}
	
	public function toNumber()
	{
		global $system;
		
		return $system->data()->toNumber($this->mixVar);
	}
	
	public function toStr()
	{
		global $system;
		
		return $system->data()->toStr($this->mixVar);
	}
}
