<?php

namespace Core\Routing\Exceptions;

use Exception;

class RoutingException extends Exception
{
    public static function notFormattedAction()
    {
        return new static('You must format route action');
    }

    public static function notFoundMethod($method)
    {
        return new static('This method '.$method.' is not found');
    }

    public static function notFoundRoute($uri)
    {
        return new static('This route '.$uri.' is not found');
    }
}
