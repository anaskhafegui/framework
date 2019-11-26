<?php

namespace Core\Database;

abstract class AbstractQuery
{   
    abstract public static function generate($params);
}