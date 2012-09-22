<?php
function loadSystemClass($class)
{
	if( file_exists(CLASSES_DIR.DS.strtolower($class).'.php' ) )
		require_once CLASSES_DIR.DS.strtolower($class).'.php';
	return;
}

function loadController($class)
{
	if( file_exists(CONTROLLERS_DIR.DS.strtolower($class).'.php') )
		require_once CONTROLLERS_DIR.DS.strtolower($class).'.php';
	return;
}

spl_autoload_register('loadSystemClass', false);
spl_autoload_register('loadController', false);
?>
