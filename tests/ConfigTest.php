<?php

namespace tests;

use Core\Config;
use PHPUnit\Framework\TestCase;

class ConfigTet extends TestCase
{
    private $config;

    public function setUp()
    {
        $configData = [
            'foo' => [
                'x' => 'y',
                'z' => 'a',
            ],
            'bar' => [
                'a' => 'b',
                'c' => 'd',
            ]
        ];

        $this->config = Config::instance();

        $this->config->set($configData);

    }

    /**
     * @test
     * 
     */
    public function get()
    {
        $this->assertSame('y', app('config')->foo['x']);
        $this->assertSame('b', app('config')->bar['a']);
    }

    /**
     * @test
     * 
     */
    public function has()
    {
        $this->assertTrue(app('config')->has('foo'));
        $this->assertTrue(app('config')->has('bar'));
    }
}