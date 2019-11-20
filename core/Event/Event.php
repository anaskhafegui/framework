<?php

namespace Core\Event;

use Interfaces\EventInterface;

class Event implements EventInterface
{
    /**
     * Event map
     *
     * @var mixed
     */
    private $map;

    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;

    private function __construct() 
    {
        
    }

    /**
     * Get Router Instance
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Register event to map
     *
     * @param string $eventName
     * @return void
     */
    public function register($eventName)
    {
        if (!isset($this->map[$eventName])) {
            $this->map[$eventName] = array();
        }
    }

    /**
     * Subscribe to event
     *
     * @param string $eventName
     * @param string $listener
     * @return void
     */
    public function subscribe($eventName, $listener)
    {
        if (! $this->isValidEvent($eventName)) return false;

        $this->map[$eventName][] = $listener; 
    }

    /**
     * Dispatch event and update listeners with params
     *
     * @param string $eventName
     * @param mixed $params
     * @return void
     */
    public function dispatch($eventName, $params)
    {
        if (! $this->isValidEvent($eventName)) return false;
        
        // execute listener with params
        foreach ($this->map[$eventName] as $callback) {
            
            if (is_array($params)) {
                call_user_func_array($callback, $params);
            } else {
                call_user_func($callback, $params);
            }
        }
    }


    /**
     * Check if this event valid to be dispatched
     *
     * @param string $eventName
     * @return boolean
     */
    public function isValidEvent($eventName): bool 
    {
        if (isset($this->map[$eventName]) || is_array($this->map[$eventName])) 
            return true;
    }
}