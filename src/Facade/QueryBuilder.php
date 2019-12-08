<?php

namespace Core\Facade;

class QueryBuilder extends Facade
{
    public static function getAccessor(): string
    {
        return 'query_builder';
    }
}