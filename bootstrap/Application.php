<?php

namespace Bootstrap;

use Exception;

class Application{

    private $container;

	/**
     * Create a new application instance.
     *
     * @return void
     */
    public function __construct(){
    	// Register Core Classes
    	$this->coreClasses();
    }


    public function coreClasses()
    {
        return [
            'session' => 'Core\Session\SessionManager'
        ];
    }

    public function registerCoreClasses(){

    	foreach ($this->coreClasses() as $key=>$class){
    		$this->instanciate($key);
    	}
    }

    public function instanciate($key){
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
            $this->set($key, $this->instanciate($key));
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

    public function run()
    {
        return $this->session->get();
    }


}