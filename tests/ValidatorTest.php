<?php

namespace tests;

use Core\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new Validator;    
    }

    /**
     * @test
     */
    public function validator()
    {
        $this->fetchInputs();

        // without validation  errors
        $rules = [
            'name' => 'required',
            'username' => 'required|min:3',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ];
        
        // has no errors
        $this->assertEmpty($this->validator->validate($rules));

        // with validation errors
        $rules2 = [
            'long_username' => 'required|max:6',
        ];

        // has errors
        $this->assertNotEmpty($this->validator->validate($rules2));

        $rules3 = [
            'age' => 'required|number',
        ];

        // has not errors
        $this->assertEmpty($this->validator->validate($rules3));
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