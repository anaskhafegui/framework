<?php

namespace Core\Facade;

class Response extends Facade
{
    public static function getAccessor(): string
    {
        return 'response';
    }
}