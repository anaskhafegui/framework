<?php 

// Some test routes
app('router')->get('/', 'HomeController@index');

app('router')->get('test', function(){
    return 'callback';
});

app('router')->post('test', 'TestController@test');

pre(app('router')->list());