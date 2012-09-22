<?php
class Mother
{
	private $pesho;
	
	public function __construct()
	{
		$this->pesho = 'gosho';
		echo 'I am the mother';
	}
}

class Child extends Mother
{
	public function __construct()
	{
		parent::__construct();
		echo $this->pesho;
	}
}

$child = new Child;
