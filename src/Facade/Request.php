<?php

namespace Core\Facade;

class Request extends Facade
{
    public static function getAccessor(): string
    {
        return 'request';
    }
}
