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
    private CONST DIR_PATH = '../config/';
    
    /**
     * Persist config arrays
     *
     * @var array
     */

    private $repository = [];

    private function __construct() 
    {
        $this->appendConfigPaths();
    }

    /**
     * Bind Config Files Paths to the Config Repository
     * 
     * @return void
     */
    public function appendConfigPaths()
    {
        foreach(app('file')->allFiles(self::DIR_PATH) as $file) {; 
            $this->bindPathToRepository($file);
        }
    }

    /**
     * Bind config path to the repository
     *
     * @return void
     */
    public function bindPathToRepository($file)
    {
        $this->repository[$this->getFileName($file)] = require_once $dirPath.$file;
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