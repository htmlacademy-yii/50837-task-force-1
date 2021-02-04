<?php

namespace Sergei404;

use Sergei404\Actions\AnswerAction;
use Sergei404\Actions\CancelAction;
use Sergei404\Actions\AcceptAction;
use Sergei404\Actions\RefuseAction;
use Sergei404\Exceptions\WrongStatus;
use Sergei404\Exceptions\WrongAction;

class TaskStrategy
{
    // статусы
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in work';
    const STATUS_PERFORMED = 'performed';
    const STATUS_FAILED = 'failed';

    //действия
    const ACTION_CANCEL = "cancel";
    const ACTION_ANSWER = "answer";
    const ACTION_ACCEPT = "accept";
    const ACTION_REFUSE = "refuse";
    const ACTION_REJECT = "reject";

    private static $statuses = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_PERFORMED => 'Принято',
        self::STATUS_FAILED => 'Провалено',
    ];

    private static $actions = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_ANSWER => 'Откликнуться',
        self::ACTION_ACCEPT => 'Принять',
        // Отказаться может исполнитель задания
        self::ACTION_REFUSE => 'Отказаться',
        // Задание отклоняется, если автор отметил "возникли проблемы" при приемке.
        self::ACTION_REJECT => 'Отклонить',
    ];

    private static $statusesWithActions = [
        self::STATUS_NEW => [self::ACTION_ANSWER, self::ACTION_CANCEL],
        self::STATUS_CANCELED => [],
        self::STATUS_IN_WORK => [self::ACTION_ACCEPT, self::ACTION_REFUSE, self::ACTION_REJECT],
        self::STATUS_PERFORMED => [],
        self::STATUS_FAILED => []
    ];

    private static $actionsWithStatuses = [
        self::ACTION_CANCEL => self::STATUS_CANCELED,
        self::ACTION_ANSWER => self::STATUS_IN_WORK,
        self::ACTION_ACCEPT => self::STATUS_PERFORMED,
        self::ACTION_REFUSE => self::STATUS_FAILED,
        self::ACTION_REJECT => self::STATUS_FAILED,
    ];

    //id заказчика и исполнителя
    private $idCustomer;
    private $idExecutor;
    private $currentStatus;

    function __construct(int $idCustomer, int $idExecutor, string $currentStatus)
    {
        $this->idCustomer = $idCustomer;
        $this->idExecutor = $idExecutor;
        if (array_key_exists($currentStatus, self::$statusesWithActions)) {
            $this->currentStatus = $currentStatus;
        } else {
            throw new WrongStatus("значение $currentStatus некорректно");
        }
    }

    /**
     * возвращает текущий статус
     */
    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }
    /**
     * возвращает id заказчика
     */
    public function getIdCustomer(): int
    {
        return $this->idCustomer;
    }
    /**
     * вщзвращает id исполнителя
     */
    public function getIdExecutor(): int
    {
        return $this->idExecutor;
    }

    /**
     * Возвращает список доступных действий для $userId
     *
     * @param int $userId ид пользователя, для которого проверяется доступность действий
     * @param string $role роль пользователя , для которой проверяется доступность действий
     * @return \Sergei404\Actions\Action[] Массив действий
     */
    public function getAvailableActions(int $userId, string $role): array
    {
        $actions = self::$statusesWithActions[$this->currentStatus];

        $actionObjectList = [];
        foreach ($actions as $action) {
            $name = 'Sergei404\Actions\\' . ucfirst($action) . 'Action';
            $actionObjectList[] = new $name();
        }

        $actionNewObjectList = [];
        foreach ($actionObjectList as $action) {
            $isAvailable = $action->isAvailable($userId, $this->getIdCustomer(), $this->getIdExecutor(), $role);
            if ($isAvailable) {
                $actionNewObjectList[] = $action;
            }
        }

        return $actionNewObjectList;
    }

    /**
     * Возвращает статус
     *
     * @param string $action
     *
     * @return string
     */
    public function getNextStatus(string $action): string
    {

        if (array_key_exists($action, self::$actionsWithStatuses)) {
            return self::$actionsWithStatuses[$action];
        }
        throw new WrongAction("значение $action некорректно");
    }
}
