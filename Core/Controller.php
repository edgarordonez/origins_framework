<?php

namespace Core;

use \Twig_Loader_Filesystem as Twig_Loader_Filesystem;
use \Twig_Environment as Twig_Environment;

abstract class Controller
{
    protected $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem('../App/Views/');
        $this->twig = new Twig_Environment($loader);
    }

    protected function display($template, $variablesTemplate)
    {
        $this->twig->display($template, $variablesTemplate);
    }

    protected function redirect($route)
    {
        header('Location: http://'. $_SERVER['HTTP_HOST'] . $route);
    }
}