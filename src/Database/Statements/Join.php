<?php

namespace Core\Database\Statements;

class Join
{
    private static $query;

    public static function generate($table, $firstColumn, $secondColumn, $type = null)
    {
        $type = $type ?? 'INNER';

        static::$query = ' '.$type.' JOIN '.$table.' ON '.$firstColumn.' = '.$secondColumn;

        return static::$query;
    }
}
