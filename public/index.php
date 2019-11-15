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

$app = new Bootstrap\Application();

echo $app->run();