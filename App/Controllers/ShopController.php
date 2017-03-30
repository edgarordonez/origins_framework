<?php

namespace App\Controllers;


use App\Producte;
use Core\Controller;

class ShopController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->userNeedAuth();
    }

    public function index()
    {
        $user = $this->getAuthUser();
        $productes = Producte::all();
        $this->display("shop/index.html.twig", [
            "productes" => $productes,
            "user" => $user
        ]);
    }
}