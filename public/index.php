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

$app = Core\Application::getInstance();
return $app;