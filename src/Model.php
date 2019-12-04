<?php

namespace Core;

abstract class Model 
{
    protected $table;

    public function all()
    {
        return $this->table($this->table)->select('*')->get();
    }
    
    public function get($id)
    {
        return $this->table($this->table)->select('*')->where('id', '=', $id)->first();
    }

    public function __call($method, $args)
    {
        return call_user_func_array([app('query_builder'), $method], $args);
    }

    public function create($data)
    {
        return $this->table($this->table)->insert($data);
    }

    public function update($id, $data)
    {
        return $this->table($this->table)->where('id', '=', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->table($this->table)->where('id', '=', $id)->delete();
    }
}