<?php
/**
 * View render
 *
 * @param string $path
 * @param array $data
 * @return mixed
 */

use Bootstrap\Application;

if (! function_exists('app')) {
    function app($key) {
        $app = Application::getInstance();
        return $app->get($key);
    }
}