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

    /**
     * Config Directory Path
     *
     * @var string
     */
    private CONST DIR_PATH = __DIR__.'/../config/';
    
    /**
     * Persist config arrays
     *
     * @var array
     */

    private $repository = [];

    private function __construct() 
    {
        $this->appendConfigData();
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
     * Bind Config Files Paths to the Config Repository
     * 
     * @return void
     */
    public function appendConfigData()
    {
        foreach(app('file')->allFiles(self::DIR_PATH) as $file) {

            $data[$this->getFileName($file)] = require_once self::DIR_PATH.$file;
        }

        $this->set($data); 
    }

    /**
     * Bind config path to the repository
     *
     * @param array $items
     * @return void
     */
    public function set($items = [])
    {
        $this->repository = $items;
    }

    /**
     * Get file name without extension
     *
     * @return string
     */
    public function getFileName($file)
    {
        return pathinfo($file, PATHINFO_FILENAME);
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

    public function get()
    {
        return $this->repository;
    }

    public function has($key)
    {
        return isset($this->repository[$key]);
    }
}