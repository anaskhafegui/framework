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
    
    /**
     * Handle matched routes with current URI
     *
     * @param Type $var
     * @return void
     */
    public function handle()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);

        // build regex with current uri
        $currentURIRegex = preg_replace("#^" . $scriptName . '#', '', $uri);

        foreach($this->list() as $route){
            $matched = true;

            // detect route parameter
            $uriRouteRegex = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['uri']);
        
            // build regex to match current url with route
            $uriRouteRegex = $currentURIRegex != '/' ? '#^/' . $uriRouteRegex . '$#' : '#^' . $route['uri'] . '$#';
            
            if (preg_match($uriRouteRegex, $currentURIRegex, $matches)) {
                
                // extract the matched route
                array_shift($matches);

                // extract params
                $params = array_values($matches);

                // check the current request method with route method
                if($route['method'] != $_SERVER['REQUEST_METHOD']){
                    $matched = false;
                }

                // if match invoke the action
                if($matched) pre($route['action']) . pre($params);
            }
        }

    }
}