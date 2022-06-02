<?php


class Route
{

    private $path;
    private $collable;
    private $params = [];
    private $matches = [];
    

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
        echo "** URL MATCH **\n";
        return true;
    }
}
