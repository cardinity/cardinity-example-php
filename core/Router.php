<?php

namespace Core;
class Router
{
    private $uri;

    public function __construct()
    {
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        $uri = substr($uri[0], strlen(getenv('PUBLIC_ROOT')));
        $uri = str_replace('/index.php', '', $uri);

        $this->uri = $uri;
    }

    public function execute($routes)
    {
        if (array_key_exists($this->uri, $routes)) {
            list($name, $action) = explode('@', $routes[$this->uri]);
            $name = ucfirst($name . 'Controller');

            if (file_exists('../app/controllers/' . $name . '.php')) {
                include_once '../app/controllers/' . $name . '.php';
                $controller = new $name;
                if (method_exists($controller, $action)) {
                    $controller->$action();
                }
            }
        }
    }
}
