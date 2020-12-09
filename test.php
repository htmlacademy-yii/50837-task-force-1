<?php

use Sergei404\TaskStrategy;

use Sergei404\Actions\AnswerAction;
use Sergei404\Actions\CancelAction;
use Sergei404\Actions\AcceptAction;
use Sergei404\Actions\RefuseAction;
use Sergei404\Exceptions\WrongStatus;
use Sergei404\Exceptions\WrongAction;

ini_set('assert.exception', 1);

require_once __DIR__ . '/vendor/autoload.php';

$testCases = [
    [new AnswerAction(), 11, 14, 14, true, 'Проверка на то, что ни автор, ни исполнитель, не могут откликнуться на задачу'],
    [new AnswerAction(), 14, 14, 14, false, 'Проверка на то, что автор задачи не может откликнуться на задачу'],
    [new CancelAction(), 14, 14, 14, true, 'Проверка на то, данный пользователь является автором задачи'],
    [new AcceptAction(), 14, 14, 16, true, 'Проверка на то, пользовтель, который является автором задачи может выполнить действие'],
    [new RefuseAction(), 16, 14, 16, true, 'Проверка на то, что исполнитель может отказаться от задачи'],
];

function testCaseActions($actionClass, $userId, $idCustomer, $idExecutor, $expected, $message)
{
    $action = new $actionClass();
    $isAvailable = $action->isAvailable($userId, $idCustomer, $idExecutor);

    try {
        assert($isAvailable === $expected, $message);
    } catch (\AssertionError $th) {
        echo ("Test failed: {$th->getMessage()}");
    }
}

foreach ($testCases as $testCase) {
    testCaseActions(...$testCase);
}

// =======================================================================================================

$expected = [
    [['Sergei404\Actions\AnswerAction'], 22, 2, 4, 'new', 'Задача в статусе new, откликнутся на задачу может user который не является ни автором, ни исполнителем данной задачи'],
    [['Sergei404\Actions\CancelAction'], 21, 2, 21, 'new', 'Задача в статусе new, автор задачи может ее отменить'],
    [['Sergei404\Actions\RefuseAction'], 2, 21, 21, 'in work', 'Задача в статусе in work, исполнитель может отказаться от задания'],
    [['Sergei404\Actions\AcceptAction', 'Sergei404\Actions\RejectAction'], 2, 21, 2, 'in work', 'Задача в статусе in work, автор задачи может принять задачу или отклонить ее'],
    [[], 2, 11, 11, 'performed', 'Задача в статусе performed, роль пользователя исполнитель - нет доступных действий'],
    [[], 2, 2, 11, 'performed', 'Задача в статусе performed, роль пользователя автор - нет доступных действий'],
];



function testAvailableActions($expect, $idCustomer, $idExecutor, $userId,  $status, $message)
{
    $taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $status);
    $availableActions = $taskStrategy->getAvailableActions($userId);

    try {
        assert(isArraysEqual($availableActions, $expect), $message);
    } catch (\AssertionError $th) {
        echo ("Test failed: {$th->getMessage()} \n");
    }
}


foreach ($expected as $expect) {
    testAvailableActions(...$expect);
}

function convertObjectToString(array $actual): array
{
    $stringValue = [];
    if (count($actual)) {
        foreach ($actual as $value) {
            $stringValue[] = get_class($value);
        }
    }
    return $stringValue;
}


function isArraysEqual(array $actual, array $expected): bool
{
    if (convertObjectToString($actual) !== $expected) {
        return false;
    }
    return true;
}

try {
    $taskStrategy = new TaskStrategy(1, 5, TaskStrategy::STATUS_IN_WORK);
} catch (WrongStatus $var) {
    echo "Test failed: <br>", $var;
}


$taskStrategy2 = new TaskStrategy(1, 5, TaskStrategy::STATUS_NEW);
try {
    $taskStrategy2->getNextStatus('refuse');
} catch (WrongAction $var) {
    echo "Test failed: <br>", $var;
}
