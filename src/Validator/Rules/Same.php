<?php

namespace Core\Validator\Rules;

use Core\Facade\Request;
use Core\Validator\Exceptions\ValidatorException;
use Core\Validator\RuleInterface;

class Same implements RuleInterface
{
    public function apply($value, $parameter)
    {
        if(is_null($parameter)) {
            throw ValidatorException::missingRuleParameter();
        }

        if ($value != Request::get($parameter)) {
            return 'same value error';
        }
    }
}
