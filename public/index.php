<?php

/*
|---------------------------------------------
| Register Autoload
|---------------------------------------------- 
*/

require "../vendor/autoload.php";



/*
|---------------------------------------------
| Run The Application 
|---------------------------------------------- 
*/

$app = Bootstrap\Application::getInstance();

echo $app->run();