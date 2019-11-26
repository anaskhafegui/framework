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
     * Join
     *
     * @var string
     */
    private $join;

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
     * @var string
     */
    private $offset;

    /**
     * Set Table
     *
     * @param string $table
     * @return object
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Select Statement
     *
     * @param string $table
     * @return object
     */
    public function select(): QueryBuilderInterface
    {
        $this->select = Select::generate(func_get_args());

        return $this;
    }

    /**
     * Where Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * @param string $type
     * 
     * @return QueryBuilderInterface
     */
    public function where(): QueryBuilderInterface
    {
        $this->where = Where::generate(func_get_args());
    
        return $this;
    }

    /**
     * orWhere Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilderInterface
     */
    public function orWhere(): QueryBuilderInterface
    {
        list($column, $operator, $value) = func_get_args();

        $this->where($column, $operator, $value, 'OR');

        return $this;
    }

    /**
     * Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @param string $type
     * @return QueryBuilderInterface
     */
    public function join(): QueryBuilderInterface
    {
        $this->join = Join::generate(func_get_args());

        return $this;
    }

    /**
     * Right Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @return QueryBuilderInterface
     */
    public function rightJoin(): QueryBuilderInterface
    {
        list($table, $firstColumn, $secondColumn) = func_get_args();

        $this->join($table, $firstColumn, $secondColumn, 'RIGHT');

        return $this;
    }

    /**
     * Left Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @return QueryBuilderInterface
     */
    public function leftJoin(): QueryBuilderInterface
    {
        list($table, $firstColumn, $secondColumn) = func_get_args();

        $this->join($table, $firstColumn, $secondColumn, 'LEFT');

        return $this;
    }    

    /**
     * GroupBy Statement
     * 
     * @return QueryBuilderInterface
     */
    public function groupBy(): QueryBuilderInterface
    {
        $this->groupBy = GroupBy::generate(func_get_args());

        return $this;
    }

    /**
     * Having Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return QueryBuilderInterface
     */
    public function having(): QueryBuilderInterface
    {
        $this->having = Having::generate(func_get_args());

        return $this;
    }

    /**
     * OrderBy Statement
     *
     * @param string $column
     * @param string $type
     * @return QueryBuilderInterface
     */
    public function orderBy(): QueryBuilderInterface
    {
        $this->orderBy = OrderBy::generate(func_get_args());
    
        return $this;
    }

    /**
     * Limit Condition
     *
     * @param string $limit
     * @return QueryBuilderInterface
     */
    public function limit(): QueryBuilderInterface
    {
        $this->limit = Limit::generate(func_get_args());

        return $this;
    }

    /**
     * Offset Statement
     *
     * @param string $offset
     * @return QueryBuilderInterface
     */
    public function offset(): QueryBuilderInterface
    {
        $this->offset = Offset::generate(func_get_args());

        return $this;
    }

    /**
     * Fetch results from the compiled query
     *
     * @return mixed
     */
    public function get(){}

    /**
     * Fetch single row from the compiled query
     *
     * @return mixed
     */
    public function first(){}

    /**
     * Execute the complied query
     *
     * @return mixed
     */
    public function execute(){}

    /**
     * Insert Records
     *
     * @param array $data
     * @return bool
     */
    public function insert($data): bool
    {
        return true;
    }

    /**
     * Update Record
     *
     * @param array $data
     * @return bool
     */
    public function update($data): bool
    {
        return true;
    }

    /**
     * Delete Record
     *
     * @return bool
     */
    public function delete(): bool
    {
        return true;
    }

    /**
     * Paginate Results
     *
     * @param int $itemPerPage
     * @return mixed
     */
    public function paginate($itemPerPage){}

    /**
     * Get Pagination Links
     *
     * @param int $currentPage
     * @param int $pages
     * @return mixed
     */
    public function links($currentPage, $pages){}

    /**
     * Render Compiled Query
     *
     * @return string
     */
    public function renderQuery(): string
    {
        $query = $this->select;
        $query .= $this->table;
        $query .= $this->join;
        $query .= $this->where;
        $query .= $this->groupBy;
        $query .= $this->having;
        $query .= $this->orderBy;
        $query .= $this->limit;
        $query .= $this->offset;

        $this->query = $query;

        return $this->query;
    }

    /**
     * Convert Object to String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->query ?? "use <strong> renderQuery() </strong> to render display complied query";
    }
}