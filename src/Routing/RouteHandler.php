<?php

namespace Core\Routing;

use Core\Routing\Exceptions\RoutingException;

class RouteHandler
{
    private $dispatcher;

    public function __construct(RouteDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle($routesList)
    {
        $uri = app('request')->uri();

        foreach ($routesList as $route) {
            $uriRouteRegex = $this->generateURIRegex($route['uri']);

            if ($matches = $this->getMatchedRoute($uriRouteRegex, $uri)) {
                $params = $this->getRouteParameters($matches);

                if ($this->isRouteMethodEqualsRequestMethod($route['method'])) {
                    $this->dispatcher->dispatch($route, $params);
                }
            }
        }

        throw RoutingException::notFoundRoute($route['uri']);
    }

    public function generateURIRegex($uri)
    {
        // detect route parameter
        $uriRouteRegex = preg_replace('/\/{(.*?)}/', '/(.*?)', $uri);

        // build regex to match current url with route
        $uriRouteRegex = $uri != '/' ? '#^/'.$uriRouteRegex.'$#' : '#^'.$uri.'$#';

        return $uriRouteRegex;
    }

    public function getMatchedRoute($uriRouteRegex, $uri)
    {
        preg_match($uriRouteRegex, $uri, $matches);

        return $matches;
    }

    public function getRouteParameters($matches)
    {
        array_shift($matches);

        return array_values($matches);
    }

    public function isRouteMethodEqualsRequestMethod($routeMethod)
    {
        return $routeMethod == app('request')->server('REQUEST_METHOD');
    }
}
