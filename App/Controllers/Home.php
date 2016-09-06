<?php
namespace App\Controllers;

use Core\App;

class Home
{
    public function __construct()
    {
    }

    public function index()
    {
        App::$twig->display('index.html', array('welcome' => 'Welcome to', 'origins' => 'origins framework'));
    }
}