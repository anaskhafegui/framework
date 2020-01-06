<?php

namespace Core\Validator\Rules;

use Core\Validator\RuleInterface;

class Number implements RuleInterface
{
    public function apply($value, $parameter)
    {
        if (!is_numeric($value)) {
            return 'number error';
        }
    }
}
