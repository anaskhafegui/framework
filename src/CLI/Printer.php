<?php

namespace Core\CLI;

class Printer
{
    public function out($message)
    {
        echo is_array($message) ? json_encode($message) : $message;
    }

    public function newLine()
    {
        $this->out("\n");
    }

    public function display($message)
    {
        $this->out($message);
        $this->newLine();
    }

}