<?php

namespace Core\Database\Statements;

class Insert
{
    public static function generate($table, $params=null)
    {
        return "INSERT INTO " .$table ." SET " . static::formatColumns($params);
    }


    public static function formatColumns($columns): string
    {
        // get only the columns which need updates
        foreach(array_keys($columns) as $column) {
            $formattedColumns[] = $column ." = ?";
        }

        return implode(", ", $formattedColumns);
    }
}