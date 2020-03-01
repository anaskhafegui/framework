<?php

namespace Core\CLI\Exceptions;

use Exception;

class CLIException extends Exception
{
    public static function argumentNotFound()
    {
        return new self('The argument is required!');
    }

    public static function notFoundCommand()
    {
        return new self('The command is not found!');
    }
}
