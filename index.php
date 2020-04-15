<?php

use Sergei404\TaskStrategy;

require_once __DIR__ .'/vendor/autoload.php';

$task = new TaskStrategy(23, 67, 'new');
var_dump($task);
