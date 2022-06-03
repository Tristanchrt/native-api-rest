<?php


class Route
{

    private $path;
    private $collable;
    private $matches = [];
    private $header;
    private $body;

    public function __construct($path, $collable)
    {
        $this->path = trim($path, '/');
        $this->collable = $collable;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }
    public function call()
    {
        $this->header = getallheaders();
        $this->body = $this->get_body();
        
        $request = $this->create_request();
        $response = json_encode(new stdClass);     

        if (is_string($this->collable)) {
            $class = explode('@', $this->collable);
            $className = $class[0];
            $m = $class[1]; 
            $controller = new $className();
            return call_user_func_array([$controller, $m], [$request, $response]);
        }else{
            return call_user_func_array($this->collable, [$request, $response]);
        }
    }

    private function get_body()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    private function create_request()
    {
        return [
            "header" => $this->header,
            "params" => $this->matches,
            "body" => $this->body,
        ];
    }
}
