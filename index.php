<?php
require_once "config/config.php";

$data = new Data();
$uri = new Uri();
$system = new System();

if( USE_DATABASE )
	$db = new dbHandler();

if( $uri->size() != 0 )
	$controllerName = $uri->getParam(1);
else
	$controllerName = DEFAULT_CONTROLLER;
	
if( USE_CACHE )
{
	$system->load()->cacheFile('cache');

	if( $system->cache()->mustRecache($uri->fullUri()) || !file_exists($system->cache()->getFullPath($uri->fullUri())) )
	{
		ob_start();

		loadPage();
	
		file_put_contents( $system->cache()->getFullPath( $uri->fullUri() ), ob_get_contents(), FILE_BINARY );
		$system->cache()->cached($uri->fullUri());
		$system->cache()->save();
		ob_end_flush();
	}
	else
		include $system->cache()->getFullPath($uri->fullUri());
}
else
	loadPage();
	
	
//-----------------------------------

function loadPage()
{
	global $system,$uri,$controllerName;
	$system->load()->controller($controllerName);
	if( $uri->size() > 1 )
	{
		$method = $uri->getParam(2);
		$system->controller($controllerName)->$method();
	}
	else
		$system->controller($controllerName)->open();
}
