<?php

namespace Core\Validator;

class Validator
{

    public function validate($rules)
    {
        // 1. loop through rules array
        foreach ($rules as $input => $inputRules) {
            // 2. extract key (input) from request
            

            // 3. explode rules by |
            foreach (explode('|', $inputRules) as $rule) {
                // 4. apply each rule on input

                // rule with parameter
                $parsingRules = explode(':', $rule);
                $rule = $parsingRules[0];
                $parameter = $parsingRules[1] ?? null;
                
                $errors[$input] = $this->applyRule($input, $rule, $parameter);

            }
        }

        return $errors;
    }


    public function applyRule($input, $rule, $parameter)
    {
        $errors = [];

        $value = app('request')->{$input};

        switch ($rule) {
            case 'min':
                if (strlen($value) < $parameter) $errors[$rule] = 'min error';
                break;

            case 'max':
                if (strlen($value) > $parameter) $errors[$rule] = 'max error';
                break;

            case 'length':
                if (strlen($value) != $parameter) $errors[$rule] = 'length error';
                break;

            case 'required':
                if (strlen($value) < 1) $errors[$rule] = 'required error';
                break;

            case 'number':
                if (! is_numeric($value)) $errors[$rule] = 'number error';
                break;
        }

        return $errors;
    }

}