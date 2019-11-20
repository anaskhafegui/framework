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


// app('router')->get('users/{id}', '');



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


// echo app('response')->send('Plain Text', 200, ['content-type' => 'application/json', 'X-Sample-Test' => 'foo']);


/*
|---------------------------------------------
| File Testing
|---------------------------------------------- 
*/



/*
|---------------------------------------------
| Event Testing
|---------------------------------------------- 
*/


app('event')->register('send-email');

app('event')->subscribe('send-email', function($name, $date){
    echo 'sending an email for ' . $name  .' @ ' . $date ."\n";
});

app('event')->subscribe('send-email', function($name, $date, $email){
    echo "<br> then activate an account ". $email;
});

app('event')->subscribe('send-email', function(){
    echo "<br> auto login with user";
});


app('event')->dispatch('send-email', ['Mohamed', 'Today', 'mg@gmail.com']);



// pre(app('event')->getMap());