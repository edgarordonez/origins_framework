<?php

//DISABLE PRODUCTION DISPLAY ERRORS
error_reporting(E_ALL);
ini_set('display_errors', 1);

//DISABLE ASSERTS PRODUCTION
assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_BAIL, true);
assert_options(ASSERT_WARNING, true);

if(!isset($_SESSION)){
    session_start();
}

define("PROJECT_PATH", dirname(__DIR__));
define("APP_PATH", PROJECT_PATH . '/App');
define("CONFIG_PATH", PROJECT_PATH . '/Config');

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../App/Views/');
$twig = new Twig_Environment($loader);

$app = new \Core\App;
$app->bootstrap($twig);