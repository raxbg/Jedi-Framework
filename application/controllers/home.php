<?php

class Home extends Controller
{
	public function Home()
	{
		parent::Controller();
	}
	
	public function open()
	{
		global $system,$uri;
		
		$data['title'] = 'I am a test';
		$data['heading'] = 'Heading 1';
		$data['num'] = 3;
		$data['gosho'] = '';
		$this->displayView('pesho', $data);
		$system->cache()->recache( '/webdev/jedi/index.php/home/close' );
	}
	
	public function test()
	{
		$data['number'] = $this->data()->post('number', false);
		$this->displayView('testValidate', $data);
	}
	
	private function empty2null($data)
	{
		if( empty($data) )
			return null;
		foreach( $data as &$item )
		{
			$item = empty($item) ? null : $item;
		}
		return $data;
	}
}
