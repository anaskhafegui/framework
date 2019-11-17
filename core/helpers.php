<?php

use Core\Application;

/**
 * resolve a class from container
 *
 * @param string $key
 * @return mixed
 */
if (! function_exists('app')) {
    function app($key) {
        return Application::getInstance()->get($key);
    }
}

/**
 * display with print_r
 *
 * @param string $value
 * @return mixed
 */
if (! function_exists('pre')) {
    function pre($value, $die=null) {
        echo "<pre>"; 
        print_r($value);
        echo "</pre>";

        if($die) die();
    }
}

