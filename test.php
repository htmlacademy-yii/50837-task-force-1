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
    [new AnswerAction(), 11, 14, 14, 'executor', true, 'Проверка на то, откликнуться может только авторизованный пользовтель, который не является ни автором, ни исполнителем данной задачи, роль - executor'],
    [new AnswerAction(), 14, 14, 14, 'executor', false, 'Проверка на то, откликнуться может только авторизованный пользовтель, который не является ни автором, ни исполнителем данной, роль - executor'],
    [new CancelAction(), 14, 14, 14, 'customer', true, 'Проверка на то, отменить может задачу в статусе new только авторизованный пользовтель, который является автором и роль - customer'],
    [new AcceptAction(), 14, 14, 16, 'customer', true, 'Проверка на то, пользовтель, который является автором задачи может выполнить определенное действие'],
    [new RefuseAction(), 16, 14, 16, 'executor', true, 'Проверка на то, что исполнитель может отказаться от задачи'],
];

function testCaseActions($actionClass, $userId, $idCustomer, $idExecutor, $role, $expected, $message)
{
    $action = new $actionClass();
    $isAvailable = $action->isAvailable($userId, $idCustomer, $idExecutor, $role);

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
    [['Sergei404\Actions\AnswerAction'], 22, 2, 4, 'executor', 'new', 'Задача в статусе new, откликнутся на задачу может user который не является ни автором задачи, роль пользователя - executor, доступное действие взять в работу'],
    [['Sergei404\Actions\CancelAction'], 21, 2, 21, 'customer', 'new', 'Задача в статусе new, автор задачи может ее отменить, роль пользователя - customer, доступное действие взять отменить'],
    [['Sergei404\Actions\RefuseAction'], 2, 21, 21, 'executor', 'in work', 'Задача в статусе in work, исполнитель может отказаться от задания, роль пользователя - executor, доступное действие отказаться'],
    [['Sergei404\Actions\AcceptAction', 'Sergei404\Actions\RejectAction'], 2, 21, 2, 'customer', 'in work', 'Задача в статусе in work, автор задачи может принять задачу или отклонить ее, роль пользователя - customer, доступные действия принять или отклонить'],
    [[], 2, 11, 11, 'executor', 'performed', 'Задача в статусе performed, роль пользователя исполнитель - нет доступных действий'],
    [[], 2, 2, 11, 'customer', 'performed', 'Задача в статусе performed, роль пользователя автор - нет доступных действий'],
];



function testAvailableActions($expect, $idCustomer, $idExecutor, $userId, $role,  $status, $message)
{
    $taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $status);
    $availableActions = $taskStrategy->getAvailableActions($userId, $role);

    try {
        assert(isArraysEqual($availableActions, $expect), $message);
    } catch (\AssertionError $th) {
        echo ("Test failed: {$th->getMessage()} \n");
    }
}


foreach ($expected as $expect) {
    testAvailableActions(...$expect);
}


/**
 * Метод возвращает массив с названиями классов переданных в нее объектов
 * @param array $objects[]
 *
 * @return array
 */
function getClassNames(array $objects): array
{
    $names = [];
    if (count($objects)) {
        foreach ($objects as $object) {
            $names[] = get_class($object);
        }
    }
    return $names;
}

function isArraysEqual(array $actual, array $expected): bool
{
    if (getClassNames($actual) !== $expected) {
        return false;
    }
    return true;
}

/**
 * При некорректно переданном статусе выкидывается исключение WrongStatus
 */
try {
    $taskStrategy = new TaskStrategy(1, 5, 'edrfgtyhujiko');

    echo "Test failed: В TaskStrategy передан некорректный статус, а исключение WrongStatus не возникло.";
} catch (WrongStatus $th) {
}

/**
 * При некорректно переданном действии выкидывается исключение WrongAction
 */
$taskStrategy = new TaskStrategy(1, 5, TaskStrategy::STATUS_NEW);
try {
    $taskStrategy2->getNextStatus('refuserftgyhujik');
    echo "Test failed: В метод getNextStatus передан некоррекеное действие, а исключение WrongAction не возникло.";
} catch (WrongAction $th) {
}
