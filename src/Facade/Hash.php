<?php

namespace Core\Facade;

class Hash extends Facade
{
    public static function getAccessor(): string
    {
        return 'hash';
    }
}
