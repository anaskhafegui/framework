<?php

namespace Core\Database\Statements;

class Update extends AbstractQuery
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

    public static function generate($params=null)
    {
        $table = $params['table']; 
        unset($params['table']);
        $columns = implode(', ', array_keys($params));
        $columns = ' ('. $columns .')';


        $values = array_map(function() { return '?'; }, $params);

        $values = implode(', ', $values);
        $values = '('. $values .')';
        
        static::$query = "UPDATE  " .$table ." " . $columns . " VALUES ". $values;
        static::$bindings[] = $params;

        return static::$query;
    }
}