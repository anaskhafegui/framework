<?php

namespace Core\Database\Statements;

class Join extends AbstractQuery
{
    private static $query;
    
    public static function generate($params)
    {
        list($table, $firstColumn, $secondColumn) = $params;

        $type = $params[3] ?? 'INNER';

        static::$query = " " .$type ." JOIN " . $table . " ON ". $firstColumn . " = ". $secondColumn;

        return static::$query;
    }
}