<?php

use Sergei404\TaskStrategy;

use Sergei404\Actions\AnswerAction;
use Sergei404\Actions\CancelAction;
use Sergei404\Actions\AcceptAction;
use Sergei404\Actions\RefuseAction;


require_once __DIR__ . '/vendor/autoload.php';

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

$answer = new AnswerAction();
$isAvailableValue = $answer->isAvailable(11, 14, 14);
assert('true == $isAvailableValue', 'Тест провален');

$cancel = new CancelAction();
$isCancelAvailableValue = $cancel->isAvailable(14, 14, 15);
assert('true == $isCancelAvailableValue', 'Тест провален');

$accept = new AcceptAction();
$isAcceptAvailableValue = $accept->isAvailable(14, 14, 13);
assert('true == $isAcceptAvailableValue', 'Тест провален');

$refuse = new RefuseAction();
$isRefuseAvailableValue = $refuse->isAvailable(11, 14, 13);
assert('true == $isCancelAvailableValue', 'Тест провален');

echo'Тесты пройдены';

$task = new TaskStrategy(12, 23, 'new');
echo '<br>';
var_dump($task->getAvailableActions());
echo '<br>';
echo $task->getCurrentStatus();
echo '<br>';
echo $task->getIdCustomer();
echo '<br>';
echo $task->getIdExecutor();
echo '<br>';
echo $task->getNextStatus('cancel');

echo '<br>';

$task2 = new TaskStrategy(12, 23, 'canceled');
echo '<br>';
var_dump($task2->getAvailableActions());
echo '<br>';
echo $task2->getCurrentStatus();
echo '<br>';
echo $task2->getIdCustomer();
echo '<br>';
echo $task2->getIdExecutor();
echo '<br>';
echo $task2->getNextStatus('answer');

echo '<br>';

$task3 = new TaskStrategy(12, 23, 'in work');
echo '<br>';
var_dump($task3->getAvailableActions());
echo '<br>';
echo $task3->getCurrentStatus();
echo '<br>';
echo $task3->getIdCustomer();
echo '<br>';
echo $task3->getIdExecutor();
echo '<br>';
echo $task3->getNextStatus('answer');
