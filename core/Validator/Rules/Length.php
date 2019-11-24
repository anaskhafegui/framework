<?php

namespace Core\Validator\Rules;

class Length extends Rule
{
    public function apply($value, $parameter)
    {
        if (strlen($value) != $parameter) return 'length error';
    }
}