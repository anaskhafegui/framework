<?php

namespace Core\Facade;

class Router extends Facade
{
    public static function getAccessor(): string
    {
        return 'router';
    }
}