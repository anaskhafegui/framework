<?php

use Core\Application;

/**
 * resolve a class from container.
 *
 * @param string $key
 *
 * @return mixed
 */
if (!function_exists('app')) {
    function app($key)
    {
        return Application::instance()->get($key);
    }
}

/**
 * display with print_r.
 *
 * @param string $value
 *
 * @return mixed
 */
if (!function_exists('pre')) {
    function pre($value, $die = null)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';

        if ($die) {
            die();
        }
    }
}

if (!function_exists('flatten')) {
    function flatten(array $array): array
    {
        $result = [];

        foreach ($array as $item) {
            if (is_null($item)) {
                continue;
            }

            $result = array_merge($result, is_array($item) ? flatten($item) : [$item]);
        }

        return $result;
    }
}

if (!function_exists('asset')) {
    function asset($path)
    {
        $appUrl = app('config')->app['url'];

        return $appUrl.$path;
    }
}
