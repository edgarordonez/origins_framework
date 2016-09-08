<?php
namespace Core;

class App
{
    private $router;
    public static $twig;

    public function __construct()
    {
        $this->router = new Router;
    }

    public function bootstrap($twig)
    {
        self::$twig = $twig;
        $this->router->render();
    }
}