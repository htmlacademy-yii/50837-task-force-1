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
    [new AnswerAction(), 11, 14, 14, 'executor', true, 'Проверка на доступность действия - откликнутбся на задачу, роль - executor'],
    [new AnswerAction(), 14, 14, 14, 'executor', false, 'Проверка на то, может ли откликнуться на задачу может пользовтель, роль - executor'],
    [new CancelAction(), 14, 14, 111, 'customer', true, 'Проверка на то, что отменить может задачу в статусе new только авторизованный пользовтель, который является автором и роль - customer'],
    [new AcceptAction(), 14, 14, 16, 'customer', true, 'Проверка на то, что пользовтель, который является автором задачи может выполнить действие -  принять задачу'],
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
    [['Sergei404\Actions\AnswerAction'], 22, 2, 4, 'executor', 'new', 'Статус задачи: new(новая); Роль пользователя на сайте: исполнитель; Роль пользователя в рамках задачи: не участник (не автор и не исполнитель); Доступны действия: Откликнуться.'],
    [['Sergei404\Actions\CancelAction'], 21, 2, 21, 'customer', 'new', 'Статус задачи: new(новая); Роль пользователя на сайте: customer(заказщик); Доступны действия: Отменить'],
    [['Sergei404\Actions\RefuseAction'], 2, 21, 21, 'executor', 'in work', 'Статус задачи: in work(в работе); Роль пользователя на сайте: executor(исполнитель); Доступны действия: Отказаться'],
    [['Sergei404\Actions\AcceptAction', 'Sergei404\Actions\RejectAction'], 2, 21, 2, 'customer', 'in work', 'Статус задачи: in work(в работе); Роль пользователя на сайте: customer(заказщик); Доступны действия: Принять или Отклонить'],
    [[], 2, 11, 11, 'executor', 'performed', 'Статус задачи: performed(выполнена); Роль пользователя на сайте: executor(исполнитель); Доступны действия: Нет доступных действий'],
    [[], 2, 2, 11, 'customer', 'performed', 'Статус задачи: performed(выполнена);  Роль пользователя на сайте: customer(заказщик); Доступны действия: Нет доступных действий'],
];



function testAvailableActions($expect, $idCustomer, $idExecutor, $userId, $role,  $status, $message)
{
    $taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $status);
    $availableActions = $taskStrategy->getAvailableActions($userId, $role);

    try {
        assert(getClassNames($availableActions) == $expect, $message);
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
