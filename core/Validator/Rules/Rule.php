<?php

namespace Core\Validator\Rules;

abstract class Rule
{
    public abstract function apply($value, $parameter);
}