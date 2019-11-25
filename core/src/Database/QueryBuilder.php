<?php

namespace Core\Database;

use Core\Interfaces\QueryBuilderInterface;

class QueryBuilder implements QueryBuilderInterface
{   
    /**
     * Final Query
     *
     * @var [type]
     */
    private $query;

    /**
     * Table Name
     *
     * @var string
     */
    private $table;

    /**
     * Where Conditions
     *
     * @var string
     */
    private $where;

    /**
     * Select Columns
     *
     * @var string
     */
    private $select = [];


    /**
     * Set Table
     *
     * @param string $table
     * @return void
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    public function select()
    {
        $columns = func_get_args();
        $columns = implode(', ', $columns);

        $this->select = $columns;

        return $this;
    }

    public function where($column, $operator, $value, $type=null)
    {
        $where = '`'. $column . '`'. $operator . $value;
        
        if (is_null($this->where)) {
            // if where not exists before
            $statement = " WHERE ". $where;
        } elseif(is_null($type)) {
            // if type not specified so set type as AND
            $statement = " AND ". $where;
        } else {
            $statement = " OR ". $where;
        }

        $this->where .= $statement;
    
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        $this->where($column, $operator, $value, 'OR');

        return $this;
    }

    public function renderQuery()
    {
        $query  = "SELECT ";
        $query .= $this->select ?? '*'; 
        $query .= " FROM ";
        $query .= $this->table;
        $query .= $this->where;

        $this->query = $query;

        return $this->query;
    }

    public function join($table, $firstColumn, $secondColumn, $type = 'INNER'){}

    public function rightJoin($table, $firstColumn, $secondColumn){}

    public function leftJoin($table, $firstColumn, $secondColumn){}    

    public function groupBy(){}

    public function having($column, $operator, $value){}

    public function orderBy($column, $type=null){}

    public function limit($limit){}

    public function offset($offset){}

    public function get(){}

    public function first(){}

    public function execute(){}

    public function insert($data){}

    public function update($data){}

    public function delete(){}

    public function paginate($itemPerPage){}

    public function links($currentPage, $pages){}
}