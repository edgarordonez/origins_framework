<?php
use Core\Router as Router;

require_once __DIR__ . '/.././Config/debug.php';

if(!isset($_SESSION)) {
    session_start();
}

define("PROJECT_PATH", dirname(__DIR__));
define("APP_PATH", PROJECT_PATH . '/App');

require_once __DIR__ . '/../vendor/autoload.php';

$bootstrap = new Router();
$bootstrap->render();