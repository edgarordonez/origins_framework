<?php

namespace Core;

use \App\Controllers\Error\Error_404Controller;

class Router
{
    private $routes = array();
    private $listUrl = array();
    private $listMethod = array();
    private $listRequest = array();
    private $trim = '/\^$'; //Regex expression. Remove the char '/' of URL

    const NAMESPACE_CONTROLLERS = '\App\Controllers\\';
    const CONTROLLERS_PATH = '../App/Controllers';

    public function __construct()
    {
        $this->routes = require_once '../Config/routes.php';

        foreach($this->routes as $key => $value) {
            $this->add($value);
        }
    }

    public function render()
    {
        $url = $this->parseUrl();

        foreach ($this->listUrl as $key => $urlInList)
        {
            if (($_SERVER['REQUEST_METHOD'] == $this->listRequest[$key]) && (preg_match('#^' . $urlInList . '$#', $url)) ) {
                $action = explode('::', $this->listMethod[$key]);
                $parameters = $this->parseParameters($url, $urlInList);

                $class = self::NAMESPACE_CONTROLLERS.$action[0];
                $controller = new $class;

                call_user_func_array([$controller, $action[1]], $parameters);
                exit;
            }
        }

        $error = new Error_404Controller;
        call_user_func_array([$error, 'index'], array());
        http_response_code(404);
        exit;
    }

    private function add($route)
    {
        list($request, $url, $controller) = $route;
        $this->listRequest[] = $request;
        $url = trim($url, $this->trim);
        $this->listUrl[] = preg_replace('/\/[[a-z0-9]+\]/', '.+', $url);
        $this->listMethod[] = $controller;
    }

    private function parseUrl()
    {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        return trim($url, $this->trim);
    }

    private function parseParameters($url, $urlInList)
    {
        $parameters = array();
        $browserUrl = explode('/', $url);
        $userUrl = explode('/', $urlInList);

        foreach ($userUrl as $key => $value) {
            if($value === '.+') {
                $parameters[] = $browserUrl[$key];
            }
        }

        return $parameters;
    }
}