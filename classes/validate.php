<?php
class Validate
{
	public function isInt($value)
	{
		return is_int($value);
	}
	
	public function isFloat($value)
	{
		return is_float($value);
	}
	
	public function isDouble($value)
	{
		return is_float($value);
	}
	
	public function isAssociativeArray($arr)
	{
		return !(array_values($arr) == $arr);
	}
	
	public function isArray($var)
	{
		return is_array($var);
	}
}
