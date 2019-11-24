<?php

namespace Core\Validator;

abstract class AbstractRule
{
    /**
     * each child rule MUST extend and implement this function
     *
     * @param string $value
     * @param string $parameter
     * @return mixed
     */
    public abstract function apply($value, $parameter);
}