<?php

namespace Core;

use Psr\Container\ContainerInterface;

class ConfigContainer implements ContainerInterface
{
    /**
     * Persist config arrays.
     *
     * @var array
     */
    private $container = [];

    public function get($key)
    {
        $this->container[$key];
    }

    /**
     * Bind config path to the container.
     *
     * @param array $items
     *
     * @return void
     */
    public function set($items = [])
    {
        $this->container = $items;
    }

    public function has($key)
    {
        return isset($this->container[$key]);
    }

    /**
     * Get key from Config Repo Magically.
     *
     * @param string $key
     *
     * @return void
     */
    public function __get($key): array
    {
        return $this->container[$key];
    }
}
