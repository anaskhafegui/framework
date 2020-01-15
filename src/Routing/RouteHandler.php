<?php

namespace Core\Routing;

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
            // if (preg_match($uriRouteRegex, $uri, $matches)) {
            $uriRouteRegex = $this->generateURIRegex($route['uri']);

            // if (preg_match($uriRouteRegex, $uri, $matches)) {
            if ($matches = $this->getMatchedRoute($uriRouteRegex, $uri)) {
                $params = $this->getRouteParameters($matches);

                // check the current request method with route method
                if ($this->isRouteMethodEqualsRequestMethod($route['method'])) {
                    return $this->dispatcher->dispatch($route, $params);
                }
            }
        }
        
        echo 'not found route';
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
        if (!is_null($matches) && is_array($matches)) {
            return array_values($matches);
        }
    }

    public function isRouteMethodEqualsRequestMethod($routeMethod)
    {
        return $routeMethod == app('request')->server('REQUEST_METHOD');
    }
}
