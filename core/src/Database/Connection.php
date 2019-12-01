<?php

namespace Core\Database;

use Core\Interfaces\ConnectionInterface;
use PDO;
use PDOException;

class Connection implements ConnectionInterface
{
    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;

    /**
     * Connection Data
     *
     * @var mixed
     */
    private $connection;

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


    public function connect()
    {
        if(is_null($this->connection)){

            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];

            $credentials = app('file')->require("../config/database.php");

            list($host, $username, $password, $database) = array_values($credentials);

            $dsn = "mysql:host=$host;dbname=$database";

            try {
                $this->connection = new PDO($dsn, $username, $password, $options);

                return $this->connection;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
            }
        }
    }
}