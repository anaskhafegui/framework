<?php

namespace Bootstrap;

use Exception;

class Application{

    private $container;

    private static $instance;

	/**
     * Create a new application instance.
     *
     * @return void
     */
    private function __construct(){
    	
        // Register Core Classes
    	$this->coreClasses();

        // Load Routes
        $this->loadWebRoutes();

        // Load Helpers
        $this->loadHelpers();
    }

    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function coreClasses()
    {
        return [
            'router' => 'Core\Router\Router',
        ];
    }

    public function registerCoreClasses(){

    	foreach ($this->coreClasses() as $key=>$class){
    		$this->instantiate($key);
    	}
    }

    public function instantiate($key){
    	$object = isset($this->coreClasses()[$key]) ? $this->coreClasses()[$key] : null;

    	return new $object;
    }

    public function __get($key)
    {
    	return $this->get($key);
    }

    public function get($key)
    {
        if (! isset($this->coreClasses()[$key])) throw new Exception("Class Not Found");
        
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

    public function loadHelpers()
    {
        require_once '../core/helpers.php';
    }
}