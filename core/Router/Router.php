<?php

namespace Core\Router;

class Router{

    /**
     * Routes List
     *
     * @var array
     */
    private $routes = [];

    /**
     * Get Routes List
     *
     * @return void
     */
    public function list()
    {
        return $this->routes;
    }

    /**
     * Add a new route
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function add($method, $uri, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'name' => '',
        ];
    }

    /**
     * Add a new GET route
     *
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function get($uri, $action)
    {
        $this->add('GET', $uri, $action);
    }

    /**
     * Add a new POST route
     *
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function post($uri, $action)
    {
        $this->add('POST', $uri, $action);
    }

    /**
     * Add a new GET|POST route
     *
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function any($uri, $action)
    {
        $this->add('POST', $uri, $action);
        $this->add('GET', $uri, $action);
    }
}