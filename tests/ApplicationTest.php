<?php

namespace tests;

use Core\Application;
use Core\FileSystem\FileSystem;
use Core\Hash\Hash;
use Core\Http\Request;
use Core\Http\Response;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{
    /**
     * hold an application instance.
     *
     * @var mixed
     */
    private $app;

    /**
     * initiate for each test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->app = Application::instance();
    }

    /**
     * @test
     */
    public function instance()
    {
        $this->assertInstanceOf(Application::class, Application::instance());
    }

    /**
     * @test
     */
    public function instantiate()
    {
        $this->assertInstanceOf(FileSystem::class, $this->app->instantiate('file'));
        $this->assertInstanceOf(Hash::class, $this->app->instantiate('hash'));
        $this->assertInstanceOf(Request::class, $this->app->instantiate('request'));
        $this->assertInstanceOf(Response::class, $this->app->instantiate('response'));
    }

    /**
     * @test
     */
    public function get()
    {
        $this->assertInstanceOf(Request::class, $this->app->get('request'));
    }

    /**
     * @test
     */
    public function has()
    {
        $this->assertTrue($this->app->has('request'));
        $this->assertFalse($this->app->has('not_found_class'));
    }

    /**
     * @test
     */
    public function set(){
        $this->app->set('new_request', $this->app->instantiate('request'));
        $this->assertTrue($this->app->has('new_request'));
    }
}
