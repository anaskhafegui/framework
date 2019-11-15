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
        $app = Application::getInstance();
        return $app->get($key);
    }
}

/**
 * display with print_r
 *
 * @param string $value
 * @return mixed
 */
if (! function_exists('pre')) {
    function pre($value) {
        echo "<pre>"; 
        print_r($value);
        echo "</pre>";
    }
}

