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

    private $handler;

    private static $prefix;

    private static $middleware = [];

    private function __construct(RouteContainer $container, RouteHandler $handler)
    {
        $this->container = $container;
        $this->handler = $handler;
    }

    /**
     * Get Router Instance.
     *
     * @return mixed
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static(new RouteContainer(), new RouteHandler(new RouteDispatcher()));
        }

        return static::$instance;
    }

    /**
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
        $route = new Route($method, $uri, $action);

        $route->setPrefix(static::$prefix);
        
        $route->setMiddleware(static::$middleware);
        
        $this->container->set($route->format());
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

    /**
     * Handle matched routes with current URI.
     *
     * @param Type $var
     *
     * @return void
     */
    public function handle()
    {
        $this->handler->handle($this->list());
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

    public static function group($options, $routes)
    {
        if (isset($options['prefix'])) {
            static::$prefix = $options['prefix'];
        }

        if (isset($options['middleware'])) {
            static::$middleware = $options['middleware'];
        }

        call_user_func($routes);
    }
}
