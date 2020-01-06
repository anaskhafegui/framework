<?php

namespace Core\Hash;

class Hash
{
    /**
     * Singleton Instance.
     *
     * @var mixed
     */
    private static $instance;

    /**
     * Routes List.
     *
     * @var array
     */
    private $routes = [];

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
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Hash the value.
     *
     * @param string $value
     *
     * @return string
     */
    public function make($value)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }
}
