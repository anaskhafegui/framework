<?php

namespace tests;

use Core\Session\Session;
use PHPUnit\Framework\TestCase;

final class SessionTest extends TestCase
{
    /**
     * hold an session instance.
     *
     * @var mixed
     */
    private $session;

    /**
     * initiate for each test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->session = Session::instance();
    }

    /**
     * @test
     */
    public function instance()
    {
        $this->assertInstanceOf(Session::class, Session::instance());
    }

    /**
     * @test
     */
    public function forget()
    {
        $this->session->set('name', 'mohamed');

        $this->assertArrayHasKey('name', $this->session->all());

        $this->session->forget('name');

        $this->assertArrayNotHasKey('name', $this->session->all());
    }

    /**
     * @test
     */
    public function destroy()
    {
        $this->session->set('name', 'mohamed');
        $this->session->set('age', '27');
        $this->session->set('job', 'developer');

        $this->assertArrayHasKey('name', $this->session->all());

        $this->session->destroy();

        $this->assertArrayNotHasKey('name', $this->session->all());
        $this->assertArrayNotHasKey('age', $this->session->all());
        $this->assertArrayNotHasKey('job', $this->session->all());

        $this->assertArrayNotHasKey('name', $this->session->all());
    }

    /**
     * @test
     */
    public function flash()
    {
        $this->session->set('name', 'mohamed');

        $this->assertArrayHasKey('name', $this->session->all());

        $this->session->flash('name');

        $this->assertArrayNotHasKey('name', $this->session->all());
    }
}
