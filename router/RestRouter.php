<?php

require_once 'Route.php';

class RestRouter
{

    private $url = null;
    public $routes = [];
    public $groups = [];
    private $current_prefix = '';
    private $total_route = '';

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function add_groups()
    {
        foreach ($this->groups as $group) {
            foreach ($group as $call) {
                call_user_func_array($call, [$this]);
            }
        }
        $this->total_route = str_replace($this->current_prefix, '', $this->total_route);
    }

    public function array_depth(array $array) {
     
    }

    public function run()
    {
        // Add groups
        for ($i = 1; $i <= 3; $i++) {
            $this->add_groups();
        }

        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            echo ('REQUEST_METHOD does not exist');
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
    }

    public function add($path, $callable, $method)
    {
        $route = new Route($this->total_route . $path, $callable);
        if (is_string($path)) {
            $this->routes[$method][] = $route;
        }
        return $route;
    }

    public function get($path, $callable)
    {
        return $this->add($path, $callable, 'GET');
    }

    public function put($path, $callable)
    {
        return $this->add($path, $callable, 'PUT');
    }
    public function delete($path, $callable)
    {
        return $this->add($path, $callable, 'DELETE');
    }

    public function post($path, $callable)
    {
        return $this->add($path, $callable, 'POST');
    }

    public function groups($prefix, $callable)
    {
        $this->groups[$prefix][] = $callable;
        $this->total_route = $this->total_route . $prefix;
        $this->current_prefix = $prefix;
    }
}
