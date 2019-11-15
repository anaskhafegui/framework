<?php

namespace Core;

use Exception;

class Application{

    /**
     * Classes Container
     *
     * @var array
     */
    private $container;

    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;

    /**
     * Core Classes
     * 
     * @var mixed
     */
    private const CORE_CLASSES = [
        'router' => 'Core\Router\Router',
    ];

	/**
     * Create a new application instance.
     *
     * @return void
     */
    private function __construct(){
        // Load Routes
        $this->loadWebRoutes();
    }

    /**
     * Get Application Instance
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Instantiate a class (Lazy Loading)
     *
     * @param string $key
     * @return mixed
     */
    public function instantiate($key){
    	$object = isset(self::CORE_CLASSES[$key]) ? self::CORE_CLASSES[$key] : null;

    	return new $object;
    }

    /**
     * If key not found, the magic method will be called
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
    	return $this->get($key);
    }

    /**
     * Return the key from the container
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if (! isset(self::CORE_CLASSES[$key])) throw new Exception("Class Not Found");
        
        if(! $this->has($key)){
            $this->set($key, $this->instantiate($key));
        }

        return $this->container[$key];
    }

    /**
     * Check if key exists in container
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->container[$key]);
    }

    /**
     * Set key in container
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * Require routes/web.php
     *
     * @return void
     */
    public function loadWebRoutes()
    {
        require_once '../routes/web.php';
    }
}