<?php

namespace tests;

use App\Middleware\AuthMiddleware;
use Core\Container;
use Core\Facade\Router;
use Core\Http\Request;
use Core\Routing\Exceptions\RoutingException;
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
        Request::create('/users/list');

        $this->router->get('users/list', 'UserController@index');

        ob_start();
        $this->router->handle();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('all users', $content);
    }

    /**
     * @test
     */
    public function routes2()
    {
        Request::create('/users/profile');

        $this->router->get('users/profile', function () {
            return 'profile';
        });

        ob_start();
        $this->router->handle();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('profile', $content);
    }

    /**
     * @test
     */
    public function options()
    {
        Request::create('/admin/users/new');

        Router::group(['prefix' => 'admin/', 'middleware' => [AuthMiddleware::class]], function () {
            Router::get('users/new', 'HomeController@new');
        });

        ob_start();
        $this->router->handle();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('new user', $content);
    }

    /**
     * @test
     */
    public function routeWithParameter()
    {
        Request::create('/admin/users/10');

        Router::group(['prefix' => 'admin/', 'middleware' => [AuthMiddleware::class]], function () {
            Router::get('users/{id}', 'UserController@show');
        });

        ob_start();
        $this->router->handle();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('profile for user with id 10', $content);
    }

    /**
     * @test
     */
    public function notFoundMethod()
    {
        $this->expectException(RoutingException::class);

        Request::create('/admin/not/found/users/10');

        Router::group(['prefix' => 'admin/not/found/', 'middleware' => [AuthMiddleware::class]], function () {
            Router::get('users/{id}', 'UserController@notFoundMethod');
        });

        $this->assertEmpty($this->router->handle());
    }

    /**
     * @test
     */
    public function notFoundRoute()
    {
        $this->expectException(RoutingException::class);

        Request::create('/admin/not/found/route/users');

        Router::group(['prefix' => 'admin/not/found/route/', 'middleware' => [AuthMiddleware::class]], function () {
            Router::get('not/found/users', 'UserController@index');
        });

        $this->assertEmpty($this->router->handle());
    }

    /**
     * @test
     */
    public function notFormattedRouteAction()
    {
        $this->expectException(RoutingException::class);

        Request::create('/admin/not/formatted/route/users');

        Router::group(['prefix' => 'admin/not/formatted/route/', 'middleware' => [AuthMiddleware::class]], function () {
            Router::get('users', 'UserController');
        });

        $this->assertEmpty($this->router->handle());
    }
}

namespace App\Http\Controllers;

class UserController
{
    public function index()
    {
        return 'all users';
    }

    public function show($id)
    {
        return 'profile for user with id '.$id;
    }
}

class HomeController
{
    public function new()
    {
        return 'new user';
    }
}

namespace App\Middleware;

class AuthMiddleware
{
    public function handle(): bool
    {
        return true;
    }
}
