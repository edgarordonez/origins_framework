<?php

namespace Core;

use \Twig_Loader_Filesystem as Twig_Loader_Filesystem;
use \Twig_Environment as Twig_Environment;
use \Twig_Extension_Debug as Twig_Extension_Debug;

abstract class Controller
{
    protected $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem('../App/Views/');
        $this->twig = new Twig_Environment($loader, [
            'debug' => true
        ]);
        $this->twig->addExtension(new Twig_Extension_Debug());
    }

    protected function display($template, $variablesTemplate)
    {
        $this->twig->display($template, $variablesTemplate);
    }

    protected function redirect($route)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $route);
    }

    protected function userNeedAuth()
    {
        if ($this->getAuthUser() === null) {
            $this->redirect('/login');
        }
    }

    protected function getAuthUser()
    {
        return isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    }
}