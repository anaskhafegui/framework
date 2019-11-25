<?php 

namespace Core\Interfaces;

interface QueryBuilderInterface
{
    public function table($table);

    public function select();

    public function join($table, $firstColumn, $secondColumn, $type = 'INNER');

    public function rightJoin($table, $firstColumn, $secondColumn);

    public function leftJoin($table, $firstColumn, $secondColumn);

    public function where($column, $operator, $value, $type=null);

    public function orWhere($column, $operator, $value);

    public function groupBy();

    public function having($column, $operator, $value);

    public function orderBy($column, $type=null);

    public function limit($limit);

    public function offset($offset);

    public function get();

    public function first();

    public function execute();

    public function insert($data);

    public function update($data);

    public function delete();

    public function paginate($itemPerPage);

    public function links($currentPage, $pages);

    public function renderQuery();

    public function __toString();
}