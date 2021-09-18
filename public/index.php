<?php
declare(strict_types = 1);
error_reporting(32767);
ini_set('display_errors', 'On');

use system\EnvLoader;
use system\Router;

//session_start();

require_once __DIR__ . '/../system/autoload.php';
EnvLoader::init()->loadEnvFile();

Router::init()
	->setRouteMethodes()
	->setRequestMethod()
	->setRequestUri()
	->route();