<?php

namespace tests;

use Core\Config;
use Core\Container;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
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
            ],
        ];
        
        $container = new Container;

        $this->config = $container->get('config');

        $this->config->set($configData);
    }

    /**
     * @test
     */
    public function get()
    {
        $this->assertSame('y', $this->config->foo['x']);
        $this->assertSame('b', $this->config->bar['a']);
    }

    /**
     * @test
     */
    public function has()
    {
        $this->assertTrue($this->config->has('foo'));
        $this->assertTrue($this->config->has('bar'));
    }
}
