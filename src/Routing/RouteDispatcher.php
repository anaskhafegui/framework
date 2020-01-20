<?php

namespace Core\Routing;

class RouteDispatcher
{
    public function dispatch($route, $params)
    {
        $this->executeMiddleware($route);

        $action = $route['action'];

        $content = is_callable($action) ? $this->invokeCallbackFunction($action, $params) : $this->invokeFunction($action, $params);

        $this->echoContent($content);
    }

    
    public function executeMiddleware($route)
    {
        if (isset($route['middleware'])) {
            $middleware = $route['middleware'];

            foreach ($middleware as $singleMiddleware) {
                if (class_exists($singleMiddleware)) {
                    // call handle() from middleware
                    if (!call_user_func_array([new $singleMiddleware(), 'handle'], [])) {
                        exit();
                    }
                } else {
                    throw new \ReflectionException('class '.$singleMiddleware.' is not found');
                }
            }
        }
    }

    public function invokeCallbackFunction($action, $params)
    {
        return call_user_func_array($action, $params);
    }

    public function invokeFunction($action, $params)
    {
        // extract controller and method from action
        list($controller, $method) = explode('@', $action);

        $controller = 'App\Http\Controllers\\'.$controller;

        // call method from controller method
        return call_user_func_array([new $controller(), $method], $params);
    }

    public function echoContent($content)
    {
        app('response')->setContent($content);

        app('response')->send();
    }
}
