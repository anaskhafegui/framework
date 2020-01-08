<?php

namespace Core;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected $container = [];

    public function get($key)
    {
        if (! $this->has($key)) {
            $this->set($key, $this->instantiate($key));
        }

        return $this->container[$key];
    }
    
    public function has($key)
    {
        return isset($this->container[$key]);
    }

    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * If key not found, the magic method will be called.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Instantiate a class (Lazy Loading) from core classes.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function instantiate($key)
    {
        $class = Application::CORE_CLASSES[$key] ?? null;

        return $class::instance();
    }
}
