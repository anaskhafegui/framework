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
     * Generated Params for Query
     *
     * @var mixed
     */
    private static $bindings = [];

    public static function generate($params)
    {
        list($column, $operator, $value) = $params;
        
        $type = $params[3] ?? null;

        $where = $column . $operator . ' ? ';
        
        if (is_null(static::$query)) {
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

        return [static::$query, static::$bindings];
    }
}