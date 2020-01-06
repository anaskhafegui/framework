<?php

namespace tests;

use Core\Http\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    /**
     * hold an request instance.
     *
     * @var mixed
     */
    private $request;

    /**
     * initiate for each test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->request = Request::instance();
    }

    /**
     * @test
     */
    public function validate()
    {
        $this->fetchInputs();

        // without validation  errors
        $rules = [
            'name'                  => 'required',
            'username'              => 'required|min:3',
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
        ];

        // has no errors
        $this->assertEmpty($this->request->validate($rules));

        // with validation errors
        $rules2 = [
            'long_username' => 'required|max:6',
        ];

        // has errors
        $this->assertNotEmpty($this->request->validate($rules2));

        $rules3 = [
            'age' => 'required|number',
        ];

        // has not errors
        $this->assertEmpty($this->request->validate($rules3));
    }

    public function fetchInputs()
    {
        $_GET['name'] = 'mohamed';
        $_GET['age'] = '27';
        $_GET['username'] = 'mgamal';
        $_GET['long_username'] = 'mgamal123456';
        $_GET['password'] = 'password';
        $_GET['password_confirmation'] = 'password';
    }
}
