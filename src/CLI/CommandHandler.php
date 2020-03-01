<?php

namespace Core\CLI;

class CommandHandler
{
    private $printer;

    public function __construct(Printer $printer)
    {
        $this->printer = $printer;
    }

    public function run(array $argv)
    {
        $input = $argv[1] ?? "World";
        $message = "Hello $input";
        $this->printer->display($message);
    }
}