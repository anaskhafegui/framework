<?php

namespace Core;

use Core\Config\Config;
use Core\Database\Connection;
use Core\Database\QueryBuilder;
use Core\FileSystem\FileSystem;
use Core\Hash\Hash;
use Core\Http\Request;
use Core\Http\Response;
use Core\Routing\Router;
use Core\Session\Session;

class Application extends Container
{
    /**
     * Singleton Instance.
     *
     * @var mixed
     */
    private static $instance;

    /**
     * Core Classes.
     *
     * @var mixed
     */
    protected const CORE_CLASSES = [
        'router'            => Router::class,
        'request'           => Request::class,
        'response'          => Response::class,
        'file'              => FileSystem::class,
        'session'           => Session::class,
        'query_builder'     => QueryBuilder::class,
        'db_connection'     => Connection::class,
        'hash'              => Hash::class,
        'config'            => Config::class,
    ];

    /**
     * Create a new application instance.
     *
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * Get Application Instance.
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
     * Require routes/web.php.
     *
     * @return void
     */
    public function loadWebRoutes()
    {
        require_once '../routes/web.php';
    }

    public function run()
    {
        // Load Routes
        $this->loadWebRoutes();
        $this->router->handle();
    }
}
