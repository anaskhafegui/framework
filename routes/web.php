<?php 

$this->router->get('/', 'HomeController@index');

$this->router->get('test', function(){
    return 'callback';
});

$this->router->post('test', 'TestController@test');
