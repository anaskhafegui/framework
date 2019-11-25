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
    private $select;

    /**
     * Group By Condition
     *
     * @var string
     */
    private $groupBy;

    /**
     * Having Condition
     *
     * @var string
     */
    private $having;

    /**
     * OrderBy
     *
     * @var string
     */
    private $orderBy;

    /**
     * Limit
     *
     * @var string
     */
    private $limit;

    /**
     * Offset
     *
     * @var stringoff
     */
    private $offset;

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

        $this->select = "SELECT ". $columns . " FROM ";

        return $this;
    }

    public function where($column, $operator, $value, $type=null)
    {
        $where = $column . $operator . $value;
        
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

    public function join($table, $firstColumn, $secondColumn, $type = 'INNER'){}

    public function rightJoin($table, $firstColumn, $secondColumn){}

    public function leftJoin($table, $firstColumn, $secondColumn){}    

    public function groupBy()
    {
        $groupBy = func_get_args();
        $groupBy = " GROUP BY ". implode (', ', $groupBy) . " ";

        $this->groupBy = $groupBy;

        return $this;
    }

    public function having($column, $operator, $value)
    {
        $having = " HAVING ". $column . $operator . $value;

        $this->having = $having;

        return $this;
    }

    public function orderBy($column, $type=null)
    {
        $type = $type ?? "ASC";
        $orderBy = $column ." ". $type;
        
        if (is_null($this->orderBy)) {
            // if orderBy not exists before
            $statement = " ORDER BY ". $orderBy;
        } else {
            $statement = ", ". $orderBy;
        }

        $this->orderBy .= $statement;
    
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = " LIMIT ". $limit;

        return $this;
    }

    public function offset($offset)
    {
        $this->offset = " OFFSET ". $offset;

        return $this;
    }

    public function get(){}

    public function first(){}

    public function execute(){}

    public function insert($data){}

    public function update($data){}

    public function delete(){}

    public function paginate($itemPerPage){}

    public function links($currentPage, $pages){}

    public function renderQuery()
    {
        $query = $this->select;
        $query .= $this->table;
        $query .= $this->where;
        $query .= $this->groupBy;
        $query .= $this->having;
        $query .= $this->orderBy;
        $query .= $this->limit;
        $query .= $this->offset;

        $this->query = $query;

        return $this->query;
    }

    public function __toString()
    {
        return $this->query ?? "No Query";
    }
}