<?php

namespace Core\Validator\Rules;

class Required extends Rule
{
    public function apply($value, $parameter)
    {
        if (strlen($value) < 1) return 'required error';
    }
}