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


// $rules = [
//     'name' => 'required|min:3|max:4|length:4',
//     'username' => 'required',
//     'age' => 'required|number'
// ];

// (count(app('request')->validate($rules)) == 0) ? pre('passed!') : pre(app('request')->validate($rules));


/*
|---------------------------------------------
| Response Testing
|---------------------------------------------- 
*/


echo app('response')->send('TexT', 200, []);