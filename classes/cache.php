<?php
class Cache
{
	private $cacheArray;
	
	private $currentlyAdded;
	
	private $file;
	
	public function Cache($filename)
	{
		$this->currentlyAdded = array();
		
		$filename = strtolower($filename.'.php');
		if( file_exists(CONFIG_DIR.DS.$filename) )
		{
			$cache = json_decode(file_get_contents(CONFIG_DIR.DS.$filename), true);
			if( is_array($cache) )
				$this->cacheArray = $cache;
			else
				die('The cache file is broken');
			$this->file = $filename;
		}
		else
			die('Could not load cache file');
	}
	
	public function recache($uri)
	{
		$uri = md5($uri);
		if( !in_array($uri, $this->cacheArray) )
		{
			$this->cacheArray[] = $uri;
			$this->currentlyAdded[] = $uri;
		}
	}
	
	public function mustRecache($uri)
	{
		return in_array(md5($uri), $this->cacheArray);
	}
	
	public function cached($uri)
	{
		$uri = md5($uri);
		
		if( in_array($uri, $this->cacheArray) && !in_array($uri, $this->currentlyAdded) )
		{
			$element = array_search(md5($uri), $this->cacheArray);
			unset($this->cacheArray[$element]);
		}
	}
	
	public function getFullPath($uri)
	{
		return CACHE_DIR.DS.md5($uri.'.php');
	}
	
	public function save()
	{
		$filename = CONFIG_DIR.DS.$this->file;
		file_put_contents($filename, json_encode($this->cacheArray));
	}
}
