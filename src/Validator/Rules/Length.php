<?php

namespace Core\Validator\Rules;

use Core\Validator\RuleInterface;

class Length implements RuleInterface
{
    public function apply($value, $parameter)
    {
        if (strlen($value) != $parameter) return 'length error';
    }
}