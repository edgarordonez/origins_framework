<?php
namespace Core;

class Controller
{
    protected function display($template, $variablesTemplate){
        App::$twig->display($template, $variablesTemplate);
    }

    protected function redirect($route)
    {
        header("Location: http://". $_SERVER['HTTP_HOST'] . $route);
    }
}