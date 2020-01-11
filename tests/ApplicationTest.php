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
    public function instantiate()
    {
        $this->assertInstanceOf(FileSystem::class, $this->app->get('file'));
        $this->assertInstanceOf(Hash::class, $this->app->get('hash'));
        $this->assertInstanceOf(Request::class, $this->app->get('request'));
        $this->assertInstanceOf(Response::class, $this->app->get('response'));

        pre($this->app->getInstances());
    }
}
