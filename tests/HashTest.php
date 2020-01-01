<?php

namespace tests;

use Core\Hash\Hash;
use PHPUnit\Framework\TestCase;

final class HashTest extends TestCase
{
    /**
     * hold an hash instance
     *
     * @var mixed
     */
    private $hash;

    /**
     * initiate for each test
     *
     * @return void
     */
    public function setUp()
    {
        $this->hash = Hash::instance();    
    }

    /**
     * @test
     */
    public function make()
    {
        $this->assertTrue(password_verify('password', $this->hash->make('password')));
    }
}