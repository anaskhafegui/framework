<?php

namespace tests;

use Core\Container;
use Core\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        $container = new Container();

        $this->request = $container->get('request');
    }

    /**
     * @test
     */
    public function method()
    {
        Request::create('/users', 'GET');
        $this->assertSame('GET', $this->request->server('REQUEST_METHOD'));

        Request::create('/users', 'POST');
        $this->assertSame('POST', $this->request->server('REQUEST_METHOD'));
    }

    /**
     * @test
     */
    public function uri()
    {
        Request::create('/users', 'GET');
        $this->assertSame('/users', $this->request->server('REQUEST_URI'));
    }

    /**
     * @test
     */
    public function url()
    {
        Request::create('/users', 'GET');
        $this->assertSame('http://localhost/users', $this->request->url());
    }    
}
