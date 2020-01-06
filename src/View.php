<?php

namespace Core;

class View
{
    public static function render($path, $data = [])
    {
        ob_start();
        extract($data);
        require realpath(__DIR__.'/..').'/views/'.$path.'.php';
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
