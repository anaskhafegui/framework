<?php

namespace Core\Database;

class Where
{
    

    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;

    private static $column;
    
    private static $operator;
    
    private static $value;
    
    private static $type;

    private static $query;
    
    private function __construct() 
    {

    }

    /**
     * Get Router Instance
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }


    public function generateQuery($column, $operator, $value, $type)
    {
        $where = $column . $operator . $value;
        
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

        return static::$query;
    }

}