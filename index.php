<?php

use Sergei404\TaskStrategy;
use Sergei404\Actions\AnswerAction;
use Sergei404\Actions\CancelAction;


require_once __DIR__ . '/vendor/autoload.php';

// $task = new TaskStrategy(23, 67, 'new');
// var_dump($task->getAvailableActions());

$answerAction = new AnswerAction();

// Проверяю ситуацию когда заказчик пытается откликнуться на свою же задачу
// $result = $answerAction->isAvailable(1, 1, null);
