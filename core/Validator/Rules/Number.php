<?php

namespace Core\Validator\Rules;

use Core\Validator\AbstractRule;

class Number extends AbstractRule
{
    public function apply($value, $parameter)
    {
        if (! is_numeric($value)) return 'number error';
    }
}