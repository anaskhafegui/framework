<?php

namespace Core;

use Exception;
use Core\Hash\Hash;
use Core\Event\Event;
use Core\Http\Request;
use Core\Http\Response;
use Core\Router\Router;
use Core\Session\Session;
use Core\Database\Connection;
use Core\Database\QueryBuilder;
use Core\FileSystem\FileSystem;


class Application
{

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
        'router'            => Router::class,
        'request'           => Request::class,
        'response'          => Response::class,
        'event'             => Event::class,
        'file'              => FileSystem::class,
        'session'           => Session::class,
        'query_builder'     => QueryBuilder::class,
        'db_connection'     => Connection::class,
        'hash'              => Hash::class,
        'config'            => Config::class,
    ];

	/**
     * Create a new application instance.
     *
     * @return void
     */
    private function __construct()
    {
        
    }

    /**
     * Get Application Instance
     *
     * @return mixed
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
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
    public function instantiate($key)
    {
        $object = isset(self::CORE_CLASSES[$key]) ? self::CORE_CLASSES[$key] : null;
        
    	return $object::instance();
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
        $this->isKeyInCoreClasses($key);

        if (! $this->has($key)) {
            $this->set($key, $this->instantiate($key));
        }

        return $this->container[$key];
    }

    /**
     * Check if the class exists in main core classes
     *
     * @param string $key
     * @return boolean
     */
    public function isKeyInCoreClasses($key)
    {
        if (! isset(self::CORE_CLASSES[$key])) throw new Exception("Class Not Found");

        return true;
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

    public function run()
    {
        // Load Routes
        $this->loadWebRoutes();
        $this->router->handle();
    }
}