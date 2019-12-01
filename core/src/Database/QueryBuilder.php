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
use Core\Database\Statements\Update;
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
     * Where Bindings
     *
     * @var mixed
     */
    private $whereBindings = [];
    
    /**
     * Having Bindings
     *
     * @var mixed
     */
    private $havingBindings = [];

    /**
     * Delete Statement
     *
     * @var string
     */
    private $delete;
    
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
    public function select($columns): QueryBuilderInterface
    {
        $this->select = Select::generate($columns);

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
    public function where($column, $operator, $value, $type=null): QueryBuilderInterface
    {
        list($this->where, $this->whereBindings) = Where::generate($column, $operator, $value);
    
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
    public function orWhere($column, $operator, $value): QueryBuilderInterface
    {
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
    public function join($table, $firstColumn, $secondColumn, $type): QueryBuilderInterface
    {
        $this->join = Join::generate($table, $firstColumn, $secondColumn, $type);

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
    public function rightJoin($table, $firstColumn, $secondColumn): QueryBuilderInterface
    {
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
    public function leftJoin($table, $firstColumn, $secondColumn): QueryBuilderInterface
    {
        $this->join($table, $firstColumn, $secondColumn, 'LEFT');

        return $this;
    }    

    /**
     * GroupBy Statement
     * 
     * @return QueryBuilderInterface
     */
    public function groupBy($column): QueryBuilderInterface
    {
        $this->groupBy = GroupBy::generate($column);

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
    public function having($column, $operator, $value): QueryBuilderInterface
    {
        list($this->having, $this->havingBindings) = Having::generate($column, $operator, $value);

        return $this;
    }

    /**
     * OrderBy Statement
     *
     * @param string $column
     * @param string $type
     * @return QueryBuilderInterface
     */
    public function orderBy($column, $type=null): QueryBuilderInterface
    {
        $this->orderBy = OrderBy::generate($column, $type);
    
        return $this;
    }

    /**
     * Limit Condition
     *
     * @param string $limit
     * @return QueryBuilderInterface
     */
    public function limit($limit): QueryBuilderInterface
    {
        $this->limit = Limit::generate($limit);

        return $this;
    }

    /**
     * Offset Statement
     *
     * @param string $offset
     * @return QueryBuilderInterface
     */
    public function offset($offset): QueryBuilderInterface
    {
        $this->offset = Offset::generate($offset);

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

        $this->bindings[] = array_merge($this->whereBindings, $this->havingBindings);


        $preparedStatement->execute(flatten($this->bindings));
                
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
     * Insert Records
     *
     * @param array $data
     * @return bool
     */
    public function insert($data): bool
    {
        // add table name to the array
        $data['table'] = $this->table;
        
        // pass all values including table name
        $query = Insert::generate($data);

        // delete the element with table name
        unset($data['table']);

        // set binding for insert statement
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
        // add table name to the array
        $data['table'] = $this->table;

        // add binding from the where statement before update to the array
        $data['where_bindings'] = $this->bindings;
        
        // add the where statement to the array
        $data['where_statement'] = $this->where;


        list($query, $this->bindings) = Update::generate($data);

        // delete the elements which are useless now
        unset($data['table']);
        unset($data['where_bindings']);
        unset($data['where_statement']);

        return $this->execute($query)->rowCount() > 0;
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
    private function renderQuery(): string
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