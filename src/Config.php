<?php

namespace Core;

class Config
{

    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;


    private $repository = [];

    private function __construct() 
    {
        $this->bindConfigPath('app');
    }


    /**
     * Bind Config File to the Config Repository
     *
     * @param string $name
     * @return void
     */
    public function bindConfigPath($name)
    {
        $this->repository[$name] = require_once '../config/'.$name.'.php';
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
     * Get key from Config Repo Magically
     *
     * @param string $key
     * @return void
     */
    public function __get($key): array
    {
        return $this->repository[$key];
    }
}