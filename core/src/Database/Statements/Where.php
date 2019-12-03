<?php

namespace Core\Database\Statements;

class Where
{
    /**
     * Generated Query
     *
     * @var string
     */
    private static $query;

    /**
     * Query Bindings
     *
     * @var string
     */
    private static $bindings;

    public static function generate($column, $operator, $value, $type=null)
    {
        $type = $type ?? null;

        $where = $column . $operator . ' ? ';
        
        if (static::$query == "") {

            // if where not exists before
            $statement = " WHERE ". $where;
        } elseif(is_null($type)) {
            // if type not specified so set type as AND
            $statement = " AND ". $where;
        } else {
            $statement = " OR ". $where;
        }

        
        static::$query .= $statement;
        static::$bindings[] = $value;

        $query = static::$query;
        $bindings = static::$bindings;
        

        return [$bindings, $query];
    }
}