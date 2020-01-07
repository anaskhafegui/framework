<?php

namespace tests;

use Core\Validator\Exceptions\ValidatorException;
use Core\Validator\Validator;
use Exception;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    /**
     * @test
     * @dataProvider validatorWithErrorsProvider
     */
    public function validatorWithErrors($rules)
    {
        $this->fetchInputs();
        
        $this->assertNotEmpty($this->validator->validate($rules));
    }

    public function validatorWithErrorsProvider()
    {
        return [
            [['long_username' => 'required|max:6',]],
            [['long_username' => 'required|max:6',]]
        ];
    }

    /**
     * @test
     * @dataProvider validatorWithoutErrorsProvider
     */
    public function validatorWithoutErrors($rules)
    {
        $this->fetchInputs();

        $this->assertEmpty($this->validator->validate($rules));
    }

    public function validatorWithoutErrorsProvider()
    {
        return 
        [
            [
                [ 
                    'name'                  => 'required',
                    'username'              => 'required|min:3',
                    'password'              => 'required',
                    'password_confirmation' => 'required|same:password',
                ]
            ],
            [
                [
                    'age' => 'required|number',
                ]
            ],

        ];
    }

    /**
     * @test
     * @dataProvider validatorWithMissingParametersProvider
     */
    public function validatorWithMissingParameters($rules)
    {
        $this->expectException(ValidatorException::class);
        
        $this->fetchInputs();

        $this->assertEmpty($this->validator->validate($rules));
    }

    public function validatorWithMissingParametersProvider()
    {
        return 
        [
            [
                [
                    'long_username' => 'max',
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validatorWithWrongRuleProvider
     */
    public function validatorWithWrongRule($rules)
    {
        $this->expectException(ValidatorException::class);
        
        $this->fetchInputs();

        $this->assertEmpty($this->validator->validate($rules));
    }

    public function validatorWithWrongRuleProvider()
    {
        return 
        [
            [
                [
                    'long_username' => 'not_found_rule',
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validatorWithWrongFormatProvider
     */
    public function validatorWithWrongFormat($rules)
    {
        $this->expectException(ValidatorException::class);
        
        $this->fetchInputs();

        $this->assertEmpty($this->validator->validate($rules));
    }

    public function validatorWithWrongFormatProvider()
    {
        return 
        [
            [
                [
                    'long_username' => 'required,max:30',
                ],
            ]
        ];
    }

    public function fetchInputs()
    {
        $_GET['name'] = 'mohamed';
        $_GET['age'] = '27';
        $_GET['username'] = 'mgamal';
        $_GET['long_username'] = 'mgamal123456';
        $_GET['password'] = '1234567';
        $_GET['password_confirmation'] = '1234567';
    }
}
