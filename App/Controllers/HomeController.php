<?php

namespace App\Controllers;

use App\Stock;
use Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->userNeedAuth();
    }

    public function index()
    {
        $user = $this->getAuthUser();
        /*$producte = Stock::find(1);
        var_dump($producte);*/
        $this->display("index.html.twig", [
            "hello" => "Welcome $user->name to",
            "origins" => "origins framework"
        ]);
    }
}