<?php

namespace Core\Validator\Rules;

class Min extends Rule
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