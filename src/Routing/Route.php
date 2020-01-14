<?php

namespace Core\Routing;

class Route
{
    private $method;

    private $uri;

    private $action;

    private $prefix;

    private $middleware = [];

    public function __construct($method = 'GET', $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

    }

    public function setMiddleware($middleware)
    {
        $this->middleware = $middleware;
    }

    public function format()
    {
        $formattedRoute = [
            'method' => $this->method,
            'uri' => $this->uri,
            'action' => $this->action,
        ];

        if ($this->prefix) {
            $formattedRoute['uri'] = $this->prefix.$formattedRoute['uri'];
            $formattedRoute['prefix'] =  $this->prefix;
        }

        if ($this->middleware) {
            $formattedRoute['middleware'] = $this->middleware;
        }

        return $formattedRoute;
    }
}
