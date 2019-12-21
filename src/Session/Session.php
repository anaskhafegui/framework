<?php

namespace Core\Session;

use Core\Interfaces\SessionInterface;

class Session implements SessionInterface
{
    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;

    private function __construct() 
    {
        $this->start();
    }

    /**
     * Get Router Instance
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
     * Set new value to the container
     * 
     * @param   string $key
     * @param   mixed $value
     * @return  void
     */
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Check if the container has a value for the given key  
     * 
     * @param   string $key
     * @return  boolean
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Get a value from the storage container
     * If no value exists for the given key, return the default value instead
     * 
     * @param   string $key
     * @param   mixed $default
     * @return  mixed
     */
    public function get(string $key, $default=null)
    {
        return $this->has($key) ? $_SESSION[$key] : $default;
    }
    
    /**
     * Get all stored values in the container
     * 
     * @return  iterable
     */
    public function all(): iterable 
    {
        return $_SESSION ?? [];
    }
    
    /**
     * Remove the value from the container
     * 
     * @param   string $key
     * @return  void
     */
    public function forget(string $key)
    {
        if (isset($_SESSION[$key])) unset($_SESSION[$key]);
    }

    /**
     * Start the session
     * 
     * @return  void
     */
    public function start()
    {
        session_start();
    }

    /**
     * Destroy the session
     * 
     * @return void
     */
    public function destroy()
    {
        foreach($this->all() as $key => $value) {
            $this->forget($key);
        }
    }

    /**
     * * Set new value to the container for one request
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function flash($key)
    {
        $value = null;
        
        if ($this->has($key)) {
            $value = $this->get($key);
            $this->forget($key);
        }

        return $value;
    }
}