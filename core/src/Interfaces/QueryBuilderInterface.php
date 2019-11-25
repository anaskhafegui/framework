<?php 

namespace Core\Interfaces;

interface QueryBuilderInterface
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
    public function select(): QueryBuilderInterface ;

    /**
     * Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @param string $type
     * @return QueryBuilderInterface
     */
    public function join($table, $firstColumn, $secondColumn, $type = 'INNER'): QueryBuilderInterface;

    /**
     * Right Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @return QueryBuilderInterface
     */
    public function rightJoin($table, $firstColumn, $secondColumn): QueryBuilderInterface;

    /**
     * Left Join Table
     *
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @return QueryBuilderInterface
     */
    public function leftJoin($table, $firstColumn, $secondColumn): QueryBuilderInterface;

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
    public function where($column, $operator, $value, $type=null): QueryBuilderInterface;

    /**
     * orWhere Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilderInterface
     */
    public function orWhere($column, $operator, $value): QueryBuilderInterface;

    /**
     * GroupBy Statement
     * 
     * @return QueryBuilderInterface
     */
    public function groupBy(): QueryBuilderInterface;

    /**
     * Having Condition
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return QueryBuilderInterface
     */
    public function having($column, $operator, $value): QueryBuilderInterface;

    /**
     * OrderBy Statement
     *
     * @param string $column
     * @param string $type
     * @return QueryBuilderInterface
     */
    public function orderBy($column, $type=null): QueryBuilderInterface;

    /**
     * Limit Condition
     *
     * @param string $limit
     * @return QueryBuilderInterface
     */
    public function limit($limit): QueryBuilderInterface;

    /**
     * Offset Statement
     *
     * @param string $offset
     * @return QueryBuilderInterface
     */
    public function offset($offset): QueryBuilderInterface;

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