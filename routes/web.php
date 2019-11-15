<?php 

app('router')->get('/', 'HomeController@index');

app('router')->get('test', function(){
    return 'callback';
});

app('router')->post('test', 'TestController@test');

print_r(app('router')->list());
