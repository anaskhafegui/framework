<?php

namespace Core\Validator\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    public static function notFormattedRules()
    {
        return new static('You Must Format Rules');
    }

    public static function notFoundRule()
    {
        return new static('This rule is not found');
    }

    public static function missingRuleParameter()
    {
        return new static('Missing Parameter');
    }
}
