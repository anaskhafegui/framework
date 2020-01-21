<?php

namespace Core\Validator\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    public static function notFormattedRules()
    {
        return new self('You Must Format Rules');
    }

    public static function notFoundRule()
    {
        return new self('This rule is not found');
    }

    public static function missingRuleParameter()
    {
        return new self('Missing Parameter');
    }
}
