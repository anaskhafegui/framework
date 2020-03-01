#!/usr/bin/php
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Core\CLI\CommandHandler;


$handler = new CommandHandler();
$handler->run($argv);