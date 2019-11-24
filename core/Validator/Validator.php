<?php

namespace Core\Validator;

class Validator
{

    public function validate($rules)
    {
        $errors = [];

        // 1. loop through rules array
        foreach ($rules as $input => $inputRules) {
            // 2. extract key (input) from request
            
            // 3. explode rules by |
            foreach (explode('|', $inputRules) as $rule) {
                // 4. apply each rule on input

                // rule with parameter
                list($rule, $parameter) = $this->parseRule($rule);
                
                // get value
                $value = $this->extractValueFromInputRequest($input);

                // get a new rule object
                $ruleObject = $this->generateRuleObject($rule);

                // fill errors array if exists
                if ($error = $ruleObject->apply($value, $parameter)) {
                    $errors[$input][$rule] = $error;
                }
            }
        }

        return $errors;
    }

    /**
     * Get value of input
     *
     * @param string $input
     * @return string
     */
    private function extractValueFromInputRequest($input): string
    {
        return app('request')->{$input};
    }

    /**
     * Generate a new object based on current rule
     *
     * @param string $rule
     * @return object
     */
    private function generateRuleObject($rule): object
    {
        $className = 'Core\\Validator\\Rules\\'.ucfirst($rule);
        return new $className();
    }

    /**
     * Parse rule with its parameters
     *
     * @param string $rule
     * @return array
     */
    public function parseRule($rule): array
    {
        $parsingRules = explode(':', $rule);
        $rule = $parsingRules[0];
        $parameter = $parsingRules[1] ?? null;

        return [$rule, $parameter];
    }
}