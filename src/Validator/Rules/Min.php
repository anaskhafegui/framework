<?php

namespace Core\Validator\Rules;

use Core\Validator\Exceptions\ValidatorException;
use Core\Validator\RuleInterface;

class Min implements RuleInterface
{
    public function apply($value, $parameter)
    {
        if (is_null($parameter)) {
            throw ValidatorException::missingRuleParameter();
        }

        if (is_numeric($value) && $value < $parameter) {
            return 'min value error';
        } elseif (!is_numeric($value) && strlen($value) < $parameter) {
            return 'min length error';
        }
    }
}
