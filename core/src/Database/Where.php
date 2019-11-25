<?php

namespace Core\Database;

class Where {

    private $column;

    private $operator;
    
    private $value;
    
    private $type;

    private $compliedQuery;

    public function __construct($column, $operator, $value, $type=null)
    {
        $this->column     = $column;
        $this->operator   = $operator;
        $this->value      = $value;
        $this->type       = $type;    
        
        $this->compliedQuery =  $this->compile();
    }

    public function compile(): string
    {
        return $this->column . $this->operator . $this->value;
    }

    public function __toString()
    {
        return $this->compliedQuery;
    }
}