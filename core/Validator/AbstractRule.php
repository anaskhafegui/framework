<?php

namespace Core\Validator;

abstract class AbstractRule
{
    public abstract function apply($value, $parameter);
}