<?php

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
    /**
     * Singleton Instance.
     *
     * @var mixed
     */
    private static $instance;

    private function __construct()
    {
    }

    /**
     * Get Router Instance.
     *
     * @return mixed
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];

            $host = app('config')->database['host'];
            $username = app('config')->database['username'];
            $password = app('config')->database['password'];
            $database = app('config')->database['database'];

            $dsn = "mysql:host=$host;dbname=$database";

            try {
                static::$instance = new PDO($dsn, $username, $password, $options);

                return static::$instance;
            } catch (PDOException $e) {
                throw new PDOException('Couldn\'t connect to the database!');
            }
        }

        return static::$instance;
    }
}
