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

class QueryBuilder
{
    /**
     * Final Query.
     *
     * @var [type]
     */
    private $query;

    /**
     * Table Name.
     *
     * @var string
     */
    private $table;

    /**
     * Where Conditions.
     *
     * @var string
     */
    private $where;

    /**
     * Select Columns.
     *
     * @var string
     */
    private $select;

    /**
     * Join.
     *
     * @var string
     */
    private $join;

    /**
     * Group By Condition.
     *
     * @var string
     */
    private $groupBy;

    /**
     * Having Condition.
     *
     * @var string
     */
    private $having;

    /**
     * OrderBy.
     *
     * @var string
     */
    private $orderBy;

    /**
     * Limit.
     *
     * @var string
     */
    private $limit;

    /**
     * Offset.
     *
     * @var string
     */
    private $offset;

    /**
     * Bindings.
     *
     * @var mixed
     */
    private $bindings = [];

    /**
     * Where Bindings.
     *
     * @var mixed
     */
    private $whereBindings = [];

    /**
     * Having Bindings.
     *
     * @var mixed
     */
    private $havingBindings = [];

    /**
     * Database Connection.
     *
     * @var mixed
     */
    private static $connection;

    /**
     * Get Single Instance.
     *
     * @return mixed
     */
    public static function instance()
    {
        return new static();
    }

    /**
     * Set Table.
     *
     * @param string $table
     *
     * @return object
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Select Statement.
     *
     * @param string $table
     *
     * @return mixed
     */
    public function select(...$columns)
    {
        $this->select = Select::generate($columns);

        return $this;
    }

    /**
     * Where Condition.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * @param string $type
     *
     * @return mixed
     */
    public function where($column, $operator, $value, $type = null)
    {
        list($this->whereBindings, $this->where) = Where::generate($column, $operator, $value);

        $this->bindings = array_merge($this->bindings, $this->whereBindings);

        return $this;
    }

    /**
     * orWhere Condition.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return mixed
     */
    public function orWhere($column, $operator, $value)
    {
        $this->where($column, $operator, $value, 'OR');

        return $this;
    }

    /**
     * Join Table.
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @param string $type
     *
     * @return mixed
     */
    public function join($table, $firstColumn, $secondColumn, $type)
    {
        $this->join = Join::generate($table, $firstColumn, $secondColumn, $type);

        return $this;
    }

    /**
     * Right Join Table.
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     *
     * @return mixed
     */
    public function rightJoin($table, $firstColumn, $secondColumn)
    {
        $this->join($table, $firstColumn, $secondColumn, 'RIGHT');

        return $this;
    }

    /**
     * Left Join Table.
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     *
     * @return mixed
     */
    public function leftJoin($table, $firstColumn, $secondColumn)
    {
        $this->join($table, $firstColumn, $secondColumn, 'LEFT');

        return $this;
    }

    /**
     * GroupBy Statement.
     *
     * @return mixed
     */
    public function groupBy($column)
    {
        $this->groupBy = GroupBy::generate($column);

        return $this;
    }

    /**
     * Having Condition.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return mixed
     */
    public function having($column, $operator, $value)
    {
        list($this->havingBindings, $this->having) = Having::generate($column, $operator, $value);

        $this->bindings = array_merge($this->bindings, $this->havingBindings);

        return $this;
    }

    /**
     * OrderBy Statement.
     *
     * @param string $column
     * @param string $type
     *
     * @return mixed
     */
    public function orderBy($column, $type = 'ASC')
    {
        $this->orderBy = OrderBy::generate($column, $type);

        return $this;
    }

    /**
     * Limit Condition.
     *
     * @param int $limit
     *
     * @return mixed
     */
    public function limit($limit)
    {
        $this->limit = Limit::generate($limit);

        return $this;
    }

    /**
     * Offset Statement.
     *
     * @param int $offset
     *
     * @return mixed
     */
    public function offset($offset)
    {
        $this->offset = Offset::generate($offset);

        return $this;
    }

    /**
     * Execute the complied query.
     *
     * @return mixed
     */
    public function execute($query = null, $parameters = [])
    {
        $connection = Connection::instance();
        $query = $query ?? $this->renderQuery();
        $parameters = !empty($parameters) ? $parameters : flatten($this->bindings);

        // prepare the query before binding variables
        $preparedStatement = $connection->prepare($query);

        // execute the query with its bindings
        $preparedStatement->execute($parameters);

        // reset the statement for new ones
        $this->reset();

        // return the statement to use fetch() or fetchAll()
        return $preparedStatement;
    }

    /**
     * Fetch results from the compiled query.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->execute()->fetchAll();
    }

    /**
     * Fetch single row from the compiled query.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->execute()->fetch();
    }

    /**
     * Insert Records.
     *
     * @param array $data
     *
     * @return bool
     */
    public function insert($data)
    {
        // pass all values including table name
        $query = Insert::generate($this->table, $data);

        // set binding for insert statement
        $this->bindings = array_values($data);

        return $this->execute($query)->rowCount() > 0;
    }

    /**
     * Update Record.
     *
     * @param array $data
     *
     * @return bool
     */
    public function update($data): bool
    {
        $query = Update::generate($this->table, $data);

        $this->bindings = array_merge(array_values($data), $this->bindings);

        // if update statement has where condition
        $query .= $this->where;

        return $this->execute($query)->rowCount() > 0;
    }

    /**
     * Delete Record.
     *
     * @return bool
     */
    public function delete(): bool
    {
        $query = Delete::generate($this->table);

        // if update statement has where condition
        $query .= $this->where;

        return $this->execute($query)->rowCount() > 0;
    }

    /**
     * Render Compiled Query.
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
     * Reset the statements.
     *
     * @return void
     */
    private function reset(): void
    {
        $this->select = '';
        $this->table = '';
        $this->join = '';
        $this->where = '';
        $this->groupBy = '';
        $this->having = '';
        $this->orderBy = '';
        $this->limit = '';
        $this->offset = '';
        $this->whereBindings = [];
        $this->havingBindings = [];
        $this->bindings = [];
        $this->query = '';
    }
}
