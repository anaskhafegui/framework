<?php

namespace Core\Routing;

class RouteDispatcher
{
    public function dispatch($route, $params)
    {
        $action = $route['action'];

        if (is_callable($action)) {
            // call a callback method
            $content = call_user_func_array($action, $params);
        } elseif (strpos($action, '@')) {

            // extract controller and method from action
            list($controller, $method) = explode('@', $action);

            $controller = 'App\Http\Controllers\\'.$controller;

            // call method from controller method
            $content = call_user_func_array([new $controller(), $method], $params);
        }

        app('response')->setContent($content);

        app('response')->send();
    }
}
