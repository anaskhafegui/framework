<?php

namespace Core\Facade;

class File extends Facade
{
    public static function getAccessor(): string
    {
        return 'file';
    }
}
