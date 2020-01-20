<?php

namespace Core\Routing\Exceptions;

use Exception;

class RoutingException extends Exception
{
    public static function notFoundMethod($method)
    {
        return new static('This method ' .$method. ' is not found');
    }
}
