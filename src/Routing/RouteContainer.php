<?php

namespace Core\Routing;

use Psr\Container\ContainerInterface;

class RouteContainer implements ContainerInterface
{
    /**
     * Persist routes arrays.
     *
     * @var array
     */
    private $container;

    public function get($key)
    {
        $this->container[$key];
    }

    /**
     * Bind route to the container.
     *
     * @param array $items
     *
     * @return void
     */
    public function set($route)
    {
        $this->container[] = $route;
    }

    public function has($key)
    {
        return isset($this->container[$key]);
    }

    public function list()
    {
        return $this->container;
    }
}
