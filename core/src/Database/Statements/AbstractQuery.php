<?php

namespace Core\Database\Statements;

abstract class AbstractQuery
{   
    abstract public static function generate($params);
}