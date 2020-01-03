<?php

namespace tests;

use Core\Validator\RuleInterface;
use Core\Validator\Rules\Length;
use Core\Validator\Rules\Max;
use Core\Validator\Rules\Min;
use Core\Validator\Rules\Number;
use Core\Validator\Rules\Required;
use Core\Validator\Rules\Same;
use PHPUnit\Framework\TestCase;

final class ValidatorRuleTest extends TestCase
{
    /**
     * @test
     * @dataProvider rule
     */
    public function apply(RuleInterface $rule, $value, $parameter){
        $this->assertNull($rule->apply($value, $parameter));
    }

    public function rule()
    {
        $_GET['password'] = '1234567';

        return [
            [new Same, '1234567', 'password'],
            [new Required, 'notEmptyValue', null],
            [new Number, 20, null],
            [new Length, 'mohamed', '7'],
            [new Max, 'mohamed', '7'],
            [new Max, '10', '100'],
            [new Min, 'mohamed gamal', '10'],
            [new Min, '200', '100'],
        ];
    }
}