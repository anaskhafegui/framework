<?php

namespace Core\Validator\Rules;

use Core\Validator\RuleInterface;

class Max implements RuleInterface
{
    public function apply($value, $parameter)
    {
        if (is_numeric($value) && $value > $parameter) {
            return 'max value error';
        } elseif (!is_numeric($value) && strlen($value) > $parameter) {
            return 'max length error';
        }
    }
}
