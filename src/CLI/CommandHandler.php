<?php

namespace Core\CLI;

use Core\CLI\Exceptions\CLIException;
use Psr\Container\ContainerInterface;

class CommandHandler implements ContainerInterface
{
    private $printer;

    private $container;

    public function __construct(Printer $printer)
    {
        $this->printer = $printer;
    }

    public function register($command, $callable)
    {
        $this->container[$command] = $callable;
    }

    public function get($command)
    {
        return $this->container[$command] ?? null;
    }

    public function has($command)
    {
        return isset($this->container[$command]);
    }

    public function run(array $argv)
    {
        $commandName = $argv[1] ?? "help";
        $command = $this->get($commandName);

        if (is_null($command)) throw CLIException::notFoundCommand();

        call_user_func($command, $argv);
    }

    public function getCommandsList()
    {
        return array_keys($this->container);
    }
}