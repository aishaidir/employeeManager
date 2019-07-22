<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();

date_default_timezone_set('Africa/Lagos');


function __autoload($class) {
	try {
		$file = __DIR__.'/' . strtolower($class) . '.php';
		if (is_file($file)) {
			require_once $file; 
		} else {
			throw new Exception("Unable to load class '" . $class . "' in file '" . $file . "'");
		} 
	}
	catch (Exception $e) {
		echo 'Exception caught: ', $e->getMessage(), "\n";
		exit();
	} 
}

$config = new Config;
$library = new Library;
$htmlControl = new HTMLControl;
$baseURL = $config::$baseURL;
$curPage = $library->curPage();

?>