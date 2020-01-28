<?php

namespace Core\Logger;

use Psr\Log\LoggerInterface;

abstract class Logger implements LoggerInterface
{
    abstract public function write($level, $message, $context = []);

    /**
     * {@inheritdoc}
     */
    public function emergency($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function alert($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function critical($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, array $context = [])
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = [])
    {
        $this->write($level, $message, $context);
    }


}
