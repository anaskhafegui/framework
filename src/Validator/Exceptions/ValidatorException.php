<?php

namespace Core\Validator\Exceptions;

use Exception;

class ValidatorException extends Exception
{

    public function notFormattedRules()
    {
        return new self('You Must Format Rules');
    }

    public function notFoundRule()
    {
        return new self('This rule is not found');
    }

    public function missingRuleParameter()
    {
        return new self('Missing Parameter');
    }
}