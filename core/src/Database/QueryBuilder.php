<?php

namespace Core\Database;

use Core\Database\Statements\Delete;
use Core\Database\Statements\GroupBy;
use Core\Database\Statements\Having;
use Core\Database\Statements\Insert;
use Core\Database\Statements\Join;
use Core\Database\Statements\Limit;
use Core\Database\Statements\Offset;
use Core\Database\Statements\OrderBy;
use Core\Database\Statements\Select;
use Core\Database\Statements\Where;
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
     * Bindings
     *
     * @var mixed
     */
    private $bindings = [];
    
    /**
     * Database Connection
     * @var mixed
     */
    private $connection;

    public function __construct()
    {
        $this->connection = app('db_connection')->connect();
    }

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
        list($this->where, $this->bindings) = Where::generate(func_get_args());
    
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
        list($this->having, $this->bindings) = Having::generate(func_get_args());

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
     * Execute the complied query
     *
     * @return mixed
     */
    public function execute($query=null)
    {
        if (is_null($query)){
            $query = $this->renderQuery();
        }
        
        $preparedStatement = $this->connection->prepare($query);
        $preparedStatement->execute($this->bindings);
                
        return $preparedStatement; 
    }

    /**
     * Fetch results from the compiled query
     *
     * @return mixed
     */
    public function get()
    {
        return $this->execute()->fetchAll();
    }

    /**
     * Fetch single row from the compiled query
     *
     * @return mixed
     */
    public function first()
    {
        return $this->execute()->fetch();
    }

    /**
     * Manipulate the statement
     *
     * @param Type $var
     * @return void
     */
    public function manipulate()
    {
        
    }

    /**
     * Insert Records
     *
     * @param array $data
     * @return bool
     */
    public function insert($data): bool
    {
        $data['table'] = $this->table;
        
        $query = Insert::generate($data);

        unset($data['table']);

        $this->bindings = array_values($data);

        return $this->execute($query)->rowCount() > 0;
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
        $this->delete = Delete::generate();
        return $this->execute()->rowCount() > 0;
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
        $query = $this->delete;
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