<?php
namespace Core;

class Controller
{
    protected function display($template, $variablesTemplate){
        App::$twig->display($template, $variablesTemplate);
    }
}