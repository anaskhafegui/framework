<?php

namespace Core\Logger\Types;

use Core\Facade\File;
use Core\Logger\Logger;

class FileLogger extends Logger
{
    public function write($level, $message, $context = [])
    {
        $this->writeToFile($level, $message);
    }

    public function formatMessage($level, $message)
    {
        $time = date('d-m-Y H:i:s');
        $message = "[$time][$level] : ".$message.PHP_EOL;
        $message .= '-------------------------------------------'.PHP_EOL;

        return $message;
    }

    public function writeToFile($level, $message)
    {
        File::append(__DIR__.'/../../../tmp/log_'.date('d-m-Y').'.txt', $this->formatMessage($level, $message));
    }
    
}