<?php

namespace Core\Routing;

class Route
{
    private $method;

    private $uri;

    private $action;

    private $prefix;

    private $middleware = [];

    public function __construct($method, $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function setMiddleware($middleware)
    {
        $this->middleware = $middleware;
        
        return $this;
    }

    public function asArray()
    {
        $route = [
            'method'    => $this->method,
            'uri'       => $this->uri,
            'action'    => $this->action,
        ];

        if ($this->prefix) {
            $route['uri'] = $this->prefix.$route['uri'];
            $route['prefix'] = $this->prefix;
        }

        if ($this->middleware) {
            $route['middleware'] = $this->middleware;
        }

        return $route;
    }
}
