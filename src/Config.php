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
     * Persist config arrays
     *
     * @var array
     */

    private $repository = [];

    private function __construct() 
    {
        $this->bindConfigPaths();
    }

    /**
     * Bind Config Files Paths to the Config Repository
     * 
     * @return void
     */
    public function bindConfigPaths()
    {
        $dirPath = '../config/';
        foreach(app('file')->allFiles($dirPath) as $file) {
            $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
            $this->repository[$fileNameWithoutExtension] = require_once $dirPath.$file;
        }
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