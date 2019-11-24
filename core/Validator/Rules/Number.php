<?php

namespace Core\Validator\Rules;

class Number extends Rule
{
    public function apply($value, $parameter)
    {
        if (! is_numeric($value)) return 'number error';
    }
}