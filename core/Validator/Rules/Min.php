<?php

namespace Core\Validator\Rules;

use Core\Validator\AbstractRule;

class Min extends AbstractRule
{
    public function apply($value, $parameter)
    {
        if (is_numeric($value) && $value < $parameter) {
            return 'min value error';
        } else if(! is_numeric($value) && strlen($value) < $parameter) {
            return 'min length error';
        }
    }
}