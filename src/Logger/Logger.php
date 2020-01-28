<?php

namespace Core\Logger;

use Psr\Log\LoggerInterface;

abstract class Logger implements LoggerInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    abstract public function write($level, $message, $context = array());

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = array()) 
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = array())
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = array())
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = array())
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = array())
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = array())
    {
        $this->write(__FUNCTION__, $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        $this->write($level, $message, $context);
    }


}
