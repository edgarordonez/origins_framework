<?php
namespace App\Controllers\Error;

use Core\Controller;

class Error_404Controller extends Controller
{
    public function index()
    {
        $this->display("/error/404.html.twig", []);
    }
}