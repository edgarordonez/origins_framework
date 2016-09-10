<?php
namespace App\Controllers;

use Core\Controller;

class Home extends Controller
{
    public function index($name = null)
    {
        $this->display("index.html.twig",
        array(
            "hello" => "Welcome $name to",
            "origins" => "origins framework"
        ));
    }
}