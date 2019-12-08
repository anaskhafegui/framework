<?php

namespace Core\Facade;

abstract class Facade 
{
    /**
     * Return the accessor
     *
     * @return void
     */
    public abstract static function getAccessor(): string;


    public static function __callStatic($method, $args)
    {
        // get instance
        $instance = app(static::getAccessor());

        // return the calling method
        return $instance->$method(...$args);
    }
}