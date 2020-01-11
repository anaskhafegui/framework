<?php

namespace Core\Config;

class Config extends ConfigContainer
{
    /**
     * Singleton Instance.
     *
     * @var mixed
     */
    private static $instance;

    /**
     * Config Directory Path.
     *
     * @var string
     */
    private const DIR_PATH = __DIR__.'/../config/';

    private function __construct()
    {
        $this->appendConfigData();
    }

    /**
     * Get Router Instance.
     *
     * @return mixed
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Bind Config Files Paths to the Config Repository.
     *
     * @return void
     */
    public function appendConfigData()
    {
        foreach (app('file')->allFiles(self::DIR_PATH) as $file) {
            $data[$this->getFileName($file)] = require_once self::DIR_PATH.$file;
        }

        $this->set($data);
    }

    /**
     * Get file name without extension.
     *
     * @return string
     */
    public function getFileName($file)
    {
        return pathinfo($file, PATHINFO_FILENAME);
    }
}
