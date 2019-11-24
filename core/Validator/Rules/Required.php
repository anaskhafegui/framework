<?php

namespace Core\Validator\Rules;

use Core\Validator\AbstractRule;

class Required extends AbstractRule
{
    public function apply($value, $parameter)
    {
        if (strlen($value) < 1) return 'required error';
    }
}