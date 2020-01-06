<?php

namespace Core\Facade;

class Session extends Facade
{
    public static function getAccessor(): string
    {
        return 'session';
    }
}
