<?php
/**
 * View render
 *
 * @param string $path
 * @param array $data
 * @return mixed
 */

use Core\Application;

if (! function_exists('app')) {
    function app($key) {
        $app = Application::getInstance();
        return $app->get($key);
    }
}

if (! function_exists('pre')) {
    function pre($value) {
        echo "<pre>"; 
        print_r($value);
        echo "</pre>";
    }
}

