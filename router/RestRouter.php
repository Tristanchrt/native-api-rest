<?php

require_once 'Route.php';

class RestRouter
{

    private $path;
    private $url = null;
    public $routes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            echo('REQUEST_METHOD does not exist');
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
    }

    public function add($path, $callable, $method)
    {
        $route = new Route($path, $callable);
        if (is_string($path)) {
            $this->routes[$method][] = $route;
        }
        return $route;
    }

    public function get($path, $callable)
    {
        return $this->add($path, $callable, 'GET');
    }

    public function post($path, $callable)
    {
        return $this->add($path, $callable, 'POST');
    }
}
