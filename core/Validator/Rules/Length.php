<?php

namespace Core\Validator\Rules;

use Core\Validator\AbstractRule;

class Length extends AbstractRule
{
    public function apply($value, $parameter)
    {
        if (strlen($value) != $parameter) return 'length error';
    }
}