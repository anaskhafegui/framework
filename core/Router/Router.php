<?php

namespace Core\Router;

class Router{

    private $routes = [];

    private $prefix = [];

    public function list()
    {
        return $this->routes;
    }

    public function add($method, $uri, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'name' => '',
        ];

        return new static;
    }

    public function get($uri, $action)
    {
        $this->add('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->add('POST', $uri, $action);
    }

    public function any($uri, $action)
    {
        $this->add('POST', $uri, $action);
        $this->add('GET', $uri, $action);
    }
}