<?php

use Sergei404\TaskStrategy;
use Sergei404\Actions\AnswerAction;
use Sergei404\Actions\CancelAction;
use Sergei404\Actions\PerformAction;
use Sergei404\Actions\RefuseAction;


require_once __DIR__ . '/vendor/autoload.php';

$task = new TaskStrategy(23, 67, 'in work');
var_dump($task->getAvailableActions());


