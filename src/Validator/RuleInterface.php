<?php

namespace Core\Validator;

interface RuleInterface
{
    /**
     * apply rule with its parameter
     *
     * @param string $value
     * @param string $parameter
     * @return mixed
     */
    public function apply($value, $parameter);
}