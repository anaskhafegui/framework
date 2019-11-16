<?php 

// Some test routes
app('router')->get('/', 'HomeController@index');

app('router')->get('test', function(){
    echo 'execute from callback';
});

app('router')->get('users/{id}', 'HomeController@users');

app('router')->handle();