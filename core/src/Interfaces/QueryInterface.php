<?php 

namespace Core\Interfaces;

interface QueryInterface
{
    /**
     * Set table
     *
     * @param string $table
     * @return void
     */
    public function table($table);

    /**
     * Select Statement
     *
     * @param string $table
     * @return object
     */
    public function select(): QueryInterface ;

    /**
     * Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @param string $type
     * @return QueryInterface
     */
    public function join($table, $firstColumn, $secondColumn, $type = 'INNER'): QueryInterface;

    /**
     * Right Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @return QueryInterface
     */
    public function rightJoin($table, $firstColumn, $secondColumn): QueryInterface;

    /**
     * Left Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @return QueryInterface
     */
    public function leftJoin($table, $firstColumn, $secondColumn): QueryInterface;

    /**
     * Where Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * @param string $type
     * 
     * @return QueryInterface
     */
    public function where($column, $operator, $value, $type=null): QueryInterface;

    /**
     * orWhere Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * 
     * @return QueryInterface
     */
    public function orWhere($column, $operator, $value): QueryInterface;

    /**
     * GroupBy Statement
     * 
     * @return QueryInterface
     */
    public function groupBy(): QueryInterface;

    /**
     * Having Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return QueryInterface
     */
    public function having($column, $operator, $value): QueryInterface;

    /**
     * OrderBy Statement
     *
     * @param string $column
     * @param string $type
     * @return QueryInterface
     */
    public function orderBy($column, $type=null): QueryInterface;

    /**
     * Limit Condition
     *
     * @param string $limit
     * @return QueryInterface
     */
    public function limit($limit): QueryInterface;

    /**
     * Offset Statement
     *
     * @param string $offset
     * @return QueryInterface
     */
    public function offset($offset): QueryInterface;

    /**
     * Fetch results from the compiled query
     *
     * @return mixed
     */
    public function get();

    /**
     * Fetch single row from the compiled query
     *
     * @return mixed
     */
    public function first();

    /**
     * Execute the complied query
     *
     * @return mixed
     */
    public function execute();

    /**
     * Insert Records
     *
     * @param array $data
     * @return bool
     */
    public function insert($data): bool;

    /**
     * Update Record
     *
     * @param array $data
     * @return bool
     */
    public function update($data): bool;

    /**
     * Delete Record
     *
     * @return bool
     */
    public function delete(): bool;

    /**
     * Paginate Results
     *
     * @param int $itemPerPage
     * @return mixed
     */
    public function paginate($itemPerPage);

    /**
     * Get Pagination Links
     *
     * @param int $currentPage
     * @param int $pages
     * @return mixed
     */
    public function links($currentPage, $pages);

    /**
     * Render Compiled Query
     *
     * @return string
     */
    public function renderQuery(): string;

    /**
     * Convert Object to String
     *
     * @return string
     */
    public function __toString();
}