<?php

namespace Core;

use Closure;
use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @param       $abstract
     * @param array $parameters
     *
     * @throws Exception
     *
     * @return mixed|null|object
     */
    public function get($abstract, $parameters = [])
    {
        // if we don't have it, just register it
        if (!$this->has($abstract)) {
            $this->set($abstract);
        }

        return $this->resolve($this->instances[$abstract], $parameters);
    }

    public function has($abstract)
    {
        return isset($this->instances[$abstract]);
    }

    /**
     * @param      $abstract
     * @param null $concrete
     */
    public function set($abstract, $concrete = null)
    {
        $concrete = Application::CORE_CLASSES[$abstract] ?? $abstract;
        $this->instances[$abstract] = $concrete;
    }

    /**
     * resolve single.
     *
     * @param $concrete
     * @param $parameters
     *
     * @throws Exception
     *
     * @return mixed|object
     */
    public function resolve($concrete, $parameters)
    {
        $reflector = new ReflectionClass($concrete);

        if ($constructor = $reflector->getConstructor()) {
            $parameters = $constructor->getParameters();
        }

        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceWithoutConstructor($dependencies);
    }

    /**
     * get all dependencies resolved.
     *
     * @param $parameters
     *
     * @throws Exception
     *
     * @return array
     */
    public function getDependencies($parameters)
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // get the type hinted class
            $dependency = $parameter->getClass();

            if (is_null($dependency)) {
                $dependencies[] = $this->getDependencyDefaultValue($parameter);
            } else {
                // get dependency resolved recursively
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }

    public function getDependencyDefaultValue($parameter)
    {
        // check if default value for a parameter is available
        if ($parameter->isDefaultValueAvailable()) {
            // get default value of parameter
            return $parameter->getDefaultValue();
        } else {
            throw new Exception("Can not resolve class dependency {$parameter->name}");
        }
    }

    public function getInstances()
    {
        return $this->instances;
    }
}
