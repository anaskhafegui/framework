<?php

namespace Core\Controllers;

use Core\Application;

abstract class BaseController
{
    public function __get($key)
    {
        return Application::instance()->get($key);
    }
}
