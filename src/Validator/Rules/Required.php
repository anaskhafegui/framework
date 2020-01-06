<?php

namespace Core\Validator\Rules;

use Core\Validator\RuleInterface;

class Required implements RuleInterface
{
    public function apply($value, $parameter)
    {
        if (strlen($value) < 1) {
            return 'required error';
        }
    }
}
