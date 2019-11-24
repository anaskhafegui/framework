<?php

namespace Core\Validator\Rules;

class Max extends Rule
{
    public function apply($value, $parameter)
    {
        if (is_numeric($value) && $value > $parameter) {
            return 'max value error';
        } else if(! is_numeric($value) && strlen($value) > $parameter) {
            return 'max length error';
        }
    }
}