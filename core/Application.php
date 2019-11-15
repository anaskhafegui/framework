<?php

namespace Core;

use Exception;

class Application{

    private $container;

    private static $instance;

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

    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function registerCoreClasses(){

    	foreach (self::CORE_CLASSES as $key=>$class){
    		$this->instantiate($key);
    	}
    }

    public function instantiate($key){
    	$object = isset(self::CORE_CLASSES[$key]) ? self::CORE_CLASSES[$key] : null;

    	return new $object;
    }

    public function __get($key)
    {
    	return $this->get($key);
    }

    public function get($key)
    {
        if (! isset(self::CORE_CLASSES[$key])) throw new Exception("Class Not Found");
        
        if(! $this->has($key)){
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

    public function loadWebRoutes()
    {
        require_once '../routes/web.php';
    }
}