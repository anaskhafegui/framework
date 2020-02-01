<?php

namespace Core\Controllers;

use Core\Application;

abstract class Controller
{
    public function __get($key)
    {
        return Application::instance()->get($key);
    }
}
