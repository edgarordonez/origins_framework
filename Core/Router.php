<?php
namespace Core;

class Router
{
    private $listUrl = array();
    private $listMethod = array();
    private $trim = '/\^$'; //Regex expression. Remove the char '/' of URL

    const NAMESPACE_CONTROLLERS = '\App\Controllers\\';
    const CONTROLLERS_PATH = '../App/Controllers';

    public function add($url, $controller)
    {
        $url = trim($url, $this->trim);
        $this->listUrl[] = $url;
        $this->listMethod[] = $controller;
    }

    public function render()
    {
        $url = $this->parseUrl();

        foreach ($this->listUrl as $key => $urlInList)
        {
            if (preg_match("#^$urlInList$#", $url))
            {
                $action = explode("::", $this->listMethod[$key]);
                $parameters = $this->parseParameters($url, $urlInList);

                $class = self::NAMESPACE_CONTROLLERS.$action[0];
                $controller = new $class;
                call_user_func_array([$controller, $action[1]], $parameters);
                exit;
            }
        }
        include_once APP_PATH . "/Views/error/404.php";
        exit;
    }

    private function parseUrl()
    {
        $url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '/';
        return trim($url, $this->trim);
    }

    private function parseParameters($url, $urlInList)
    {
        $parameters = array();
        $browserUrl = explode('/', $url);
        $userUrl = explode('/', $urlInList);

        foreach ($userUrl as $key => $value)
        {
            if($value === '.+')
            {
                $parameters[] = $browserUrl[$key];
            }
        }
        return $parameters;
    }
}