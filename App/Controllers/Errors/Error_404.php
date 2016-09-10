<?php
namespace App\Controllers\Errors;

use Core\Controller;

class Error_404 extends Controller
{
    public function index()
    {
        $this->display("/error/404.html.twig", []);
    }
}