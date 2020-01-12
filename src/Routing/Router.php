<?php

namespace Core\Routing;

class Router
{
    /**
     * Singleton Instance.
     *
     * @var mixed
     */
    private static $instance;

    /**
     * Routes Container.
     */
    private $container;

    private function __construct(RouteContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Get Router Instance.
     *
     * @return mixed
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static(new RouteContainer);
        }

        return static::$instance;
    }

    /**
     *
     * Get Routes List.
     *
     * @return void
     */
    public function list()
    {
        return $this->container->list();
    }

    /**
     * Add a new route to container.
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public function add($method, $uri, $action)
    {
        $this->container->set(
            [
                'method' => $method,
                'uri'    => $uri,
                'action' => $action,
            ]
        );
    }

    /**
     * Add a new GET route.
     *
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public function get($uri, $action)
    {
        $this->add('GET', $uri, $action);
    }

    /**
     * Add a new POST route.
     *
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public function post($uri, $action)
    {
        $this->add('POST', $uri, $action);
    }

    /**
     * Add a new GET|POST route.
     *
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public function any($uri, $action)
    {
        $this->add('POST', $uri, $action);
        $this->add('GET', $uri, $action);
    }

    public function name()
    {
        # code...
    }

    /**
     * Handle matched routes with current URI.
     *
     * @param Type $var
     *
     * @return void
     */
    public function handle()
    {
        $uri = app('request')->server('REQUEST_URI');
        $scriptName = dirname(app('request')->server('SCRIPT_NAME'));

        // build regex with current uri
        $currentURIRegex = preg_replace('#^'.$scriptName.'#', '', $uri);

        foreach ((array) $this->list() as $route) {
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
                    
                    return $this->invoke($route, $params);
                }
            }
        }

        echo 'not found route';
    }

    /**
     * Call the route action.
     *
     * @param string $route
     * @param array  $params
     *
     * @return void
     */
    public function invoke($route, $params)
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

    /**
     * Redirect the request to the path.
     *
     * @param $path
     *
     * @return void
     */
    public function redirect($path)
    {
        // remove useless slashes from url
        $path = preg_replace('/([^:])(\/{2,})/', '$1/', $path);
        header('Location: '.$path);
        exit;
    }
}
