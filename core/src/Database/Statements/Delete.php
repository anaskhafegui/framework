<?php

namespace Core\Database\Statements;

class Delete
{
    /**
     * Generated Query
     *
     * @var string
     */
    private static $query;


    public static function generate($params=null)
    {
        // set table name
        $table = $params['table']; 

        unset($params['table']);
        
        static::$query = "DELETE FROM ". $table;

        // get where statement
        $whereStatement = $params['where_statement'];

        return static::$query. $whereStatement;
    }
}