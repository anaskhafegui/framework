<?php 

/*
|---------------------------------------------
| Routing Testing
|---------------------------------------------- 
*/

app('router')->get('/', 'HomeController@index');


// app('router')->get('test', function(){
//     echo 'execute from callback';
// });


app('router')->get('users/{id}', '');



/*
|---------------------------------------------
| Request Testing
|---------------------------------------------- 
*/



echo request('key');