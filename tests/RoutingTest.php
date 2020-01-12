<?php

namespace tests;

use Core\Container;
use PHPUnit\Framework\TestCase;

final class RoutingTest extends TestCase
{
    private $router;

    public function setUp()
    {
        $container = new Container();

        $this->router = $container->get('router');
    }

    /**
     * @test
     */
    public function routes()
    {
        $this->router->post('users/login', 'UserController@login');
        $this->router->get('users/list', 'UserController@index');
        $this->router->get('users/profile', 'UserController@profile');
        

        pre($this->router->handle(), 1);
    }
}