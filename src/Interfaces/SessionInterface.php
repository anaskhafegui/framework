<?php 

namespace Core\Interfaces;

interface SessionInterface
{
    /**
     * Set new value to the container
     * 
     * @param   string $key
     * @param   mixed $value
     * @return  void
     */
    public function set(string $key, $value);
    
    /**
     * Check if the container has a value for the given key  
     * 
     * @param   string $key
     * @return  boolean
     */
    public function has(string $key): bool;
    
    /**
     * Get a value from the storage container
     * If no value exists for the given key, return the default value instead
     * 
     * @param   string $key
     * @param   mixed $default
     * @return  mixed
     */
    public function get(string $key, $default=null);
    
    /**
     * Get all stored values in the container
     * 
     * @return  iterable
     */
    public function all(): iterable;
    
    /**
     * Remove the value from the container
     * 
     * @param   string $key
     * @return  void
     */
    public function forget(string $key);

    /**
     * Start the session
     * 
     * @return  void
     */
    public function start();
    /**
     * Destroy the session
     * 
     * @return void
     */
    public function destroy();

    /**
     * Get a value to the container for one request
     *
     * @param string $key
     * @return void
     */
    public function flash($key);
}