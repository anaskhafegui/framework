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
     * @return mixed|null|object
     * @throws Exception
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
        if ($concrete === null) {
            $concrete = Application::CORE_CLASSES[$abstract] ?? null;
        }
        $this->instances[$abstract] = $concrete;
    }

    /**
     * resolve single
     *
     * @param $concrete
     * @param $parameters
     *
     * @return mixed|object
     * @throws Exception
     */
    public function resolve($concrete, $parameters)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }
        
        $reflector = new ReflectionClass($concrete);
        
        // get class constructor
        $constructor = $reflector->getConstructor();

        // get constructor params
        $parameters   = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceWithoutConstructor($dependencies);
    }
    
    /**
     * get all dependencies resolved
     *
     * @param $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getDependencies($parameters)
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // get the type hinted class
            $dependency = $parameter->getClass();
            
            if ($dependency === null) {
                // check if default value for a parameter is available
                if ($parameter->isDefaultValueAvailable()) {
                    // get default value of parameter
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("Can not resolve class dependency {$parameter->name}");
                }
            } else {
                // get dependency resolved
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }
}
