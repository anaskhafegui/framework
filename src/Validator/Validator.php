<?php

namespace Core\Validator;

use Core\Validator\Exceptions\ValidatorException;
use Core\Validator\Rules\Length;
use Core\Validator\Rules\Max;
use Core\Validator\Rules\Min;
use Core\Validator\Rules\Number;
use Core\Validator\Rules\Required;
use Core\Validator\Rules\Same;

class Validator
{
    private const RULES = [
        'length'    => Length::class,
        'max'       => Max::class,
        'min'       => Min::class,
        'number'    => Number::class,
        'required'  => Required::class,
        'same'      => Same::class,
    ];

    /**
     * Validate the inputs with specified rules.
     *
     * @param array $rules
     *
     * @return array
     */
    public function validate($rules): array
    {
        foreach ($rules as $input => $inputRules) {
            $errors = $this->applyRulesForInput($input, $inputRules);
        }

        $this->persistErrorsToSession($errors);

        return $this->removeEmptyValuesFromErrors($errors);
    }

    /**
     * Apply each rule on one only input, then return if errors found.
     *
     * @param string $input
     * @param array  $rules
     *
     * @return void
     */
    public function applyRulesForInput($input, $rules): array
    {
        $explodedRules = explode('|', $rules);

        if (! $this->isFormattedRules($explodedRules)) {
            throw ValidatorException::notFormattedRules();
        }

        // divide rules by |
        foreach ($explodedRules as $rule) {
            // apply each rule on input
            $errors = $this->applyOneRuleForInput($rule, $input);
        }

        return $errors;
    }

    /**
     * check if the rule has a desired format.
     *
     * @return void
     */
    public function isFormattedRules($explodedRules)
    {
        // TODO: refactor with regex
        return is_array($explodedRules);
    }

    /**
     * Apply only one rule to the input.
     *
     * @param string $ruleString
     * @param string $input
     *
     * @return array
     */
    public function applyOneRuleForInput($ruleString, $input): array
    {
        list($ruleString, $parameter) = $this->parseRule($ruleString);

        $value = $this->extractValueFromInputRequest($input);

        $ruleObject = $this->generateRuleObjectFromString($ruleString);

        $errors[$input][$ruleString] = $this->detectErrors($ruleObject, $value, $parameter);

        return $errors;
    }

    /**
     * Parse rule with its parameters.
     *
     * @param string $rule
     *
     * @return array
     */
    public function parseRule($rule): array
    {
        $parsingRules = explode(':', $rule);
        list($rule, $parameter) = array_pad($parsingRules, 2, null);

        return [$rule, $parameter];
    }

    /**
     * Get value of input.
     *
     * @param string $input
     *
     * @return string|null
     */
    private function extractValueFromInputRequest($input): ?string
    {
        return app('request')->{$input};
    }

    /**
     * Generate a new object based on current rule.
     *
     * @param string $rule
     *
     * @return object
     */
    private function generateRuleObjectFromString($rule)
    {
        if (! $this->isRuleExists($rule)) {
            throw ValidatorException::notFoundRule();
        }
        $ruleName = self::RULES[$rule];

        return new $ruleName();
    }

    public function isRuleExists($rule)
    {
        return array_key_exists($rule, self::RULES);
    }

    /**
     * Detect errors while applying rules on input.
     *
     * @param mixed $ruleObject
     * @param mixed $value
     * @param mixed $parameter
     *
     * @return mixed
     */
    public function detectErrors($ruleObject, $value, $parameter)
    {
        return $ruleObject->apply($value, $parameter);
    }

    /**
     * Persist validation errors to session.
     *
     * @param array errors
     *
     * @return void
     */
    public function persistErrorsToSession($errors): void
    {
        app('session')->set('errors', $errors);
    }

    /**
     * Remove useless or empty keys from errors.
     *
     * @param mixed $errors
     *
     * @return array
     */
    public function removeEmptyValuesFromErrors($errors): array
    {
        return array_filter(array_map('array_filter', $errors));
    }
}
