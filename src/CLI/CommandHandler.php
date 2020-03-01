<?php

namespace Core\CLI;

class CommandHandler
{
    public function run(array $argv)
    {
        $name = $argv[1] ?? "World";
        echo "Hello $name \n";
    }
}