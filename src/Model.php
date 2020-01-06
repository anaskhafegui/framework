<?php

namespace Core;

abstract class Model
{
    protected $table;

    /**
     * Call any function which is not exist in this class but exists in QueryBuilder class.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([app('query_builder'), $method], $args);
    }

    /**
     * Get all records from specific table.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->table($this->table)->select('*')->get();
    }

    /**
     * Get only one record from specific table.
     *
     * @param int $id
     *
     * @return void
     */
    public function get($id)
    {
        return $this->table($this->table)->select('*')->where('id', '=', $id)->first();
    }

    /**
     * Create new record.
     *
     * @param array $data
     *
     * @return bool
     */
    public function create($data)
    {
        return $this->table($this->table)->insert($data);
    }

    /**
     * Update a record.
     *
     * @param int   $id
     * @param array $data
     *
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->table($this->table)->where('id', '=', $id)->update($data);
    }

    /**
     * Delete a record.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->table($this->table)->where('id', '=', $id)->delete();
    }
}
