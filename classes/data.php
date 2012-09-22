<?php
class Data
{
	//sanitize function must be separate
	private $validate;
	
	private $dataHelper;
	
	public function Data()
	{
		$this->validate = new Validate();
		$this->dataHelper = new DataHelper();
	}
	
	public function post($name, $obj = true, $sanitizeLevel = 'full')
	{
		$dataVal = $this->sanitize($_POST[$name], $sanitizeLevel);
		if( $obj === true )
		{
			$this->dataHelper->setVar($dataVal);
			return $this->dataHelper;
		}
		else
			return $dataVal;
	}
	
	public function get($name, $obj = true, $sanitizeLevel = 'full')
	{
		$dataVal = $this->sanitize($_GET[$name], $sanitizeLevel);
		if( $obj === true )
		{
			$this->dataHelper->setVar($dataVal);
			return $this->dataHelper;
		}
		else
			return $dataVal;
	}
	
	public function validate()
	{
		return $this->validate;
	}
	
	public function sanitize($value, $sanitizeLevel = 'full')
	{
		global $system;
		
		if( !$sanitizeLevel )
			return !empty( $value ) ? $value : false;
		if( empty($value) )
				return false;
		$value = trim($value);
		if( $sanitizeLevel == 'full' )
			$value = htmlentities($value, ENT_QUOTES);
		if( $sanitizeLevel == 'mysql' || $sanitizeLevel == 'full' )
			if( $system->hasDbConnection() )
				$value = mysql_real_escape_string($value);
		return $value;
	}
	
	public function parseInt($value)
	{
		if( !empty($value) && is_numeric($value) )
		{
			$value = ltrim($value,'0');
			return intval($value);
		}
		else
			return false;
	}
	
	public function parseFloat($value)
	{
		if( !empty($value) && is_numeric($value) )
		{
			$value = ltrim($value, '0');
			return floatval($value);
		}
		else
			return false;
	}
	
	public function parseDouble($value)
	{
		return $this->parseFloat($value);
	}
	
	public function toNumber($value, $decimals = 2)
	{
		if( !empty($value) && is_numeric($value) )
		{
			$value = ltrim($value, '0');
			return number_format($value, $decimals);
		}
		else
			return false;
	}
	
	public function toStr($value)
	{
		if( !empty($value) )
			return strval($value);
		else
			return false;
	}
}
