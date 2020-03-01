<?php

namespace Core\CLI;

class Printer
{
    public function out($message)
    {
        echo $message;
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