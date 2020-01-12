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
        $uri = app('request')->server('REQUEST_URI');
        $scriptName = dirname(app('request')->server('SCRIPT_NAME'));

        // build regex with current uri
        $currentURIRegex = preg_replace('#^'.$scriptName.'#', '', $uri);

        foreach ((array) $routesList as $route) {
            $matched = true;

            // detect route parameter
            $uriRouteRegex = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['uri']);

            // build regex to match current url with route
            $uriRouteRegex = $currentURIRegex != '/' ? '#^/'.$uriRouteRegex.'$#' : '#^'.$route['uri'].'$#';

            if (preg_match($uriRouteRegex, $currentURIRegex, $matches)) {

                // extract the matched route
                array_shift($matches);

                // extract params
                $params = array_values($matches);

                // check the current request method with route method
                if ($route['method'] != app('request')->server('REQUEST_METHOD')) {
                    $matched = false;
                }

                // if match invoke the action
                if ($matched) {
                    return $this->dispatcher->dispatch($route, $params);
                }
            }
        }

        echo 'not found route';
    }
}