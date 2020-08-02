<?php

namespace Sergei404;

use Sergei404\Actions\AnswerAction;
use Sergei404\Actions\CancelAction;
use Sergei404\Actions\PerformAction;
use Sergei404\Actions\RefuseAction;

class TaskStrategy
{
    // статусы
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in work';
    const STATUS_PERFORMED = 'performed';
    const STATUS_FAILED = 'failed';

    //действия
    // const ACTION_CANCEL = "\Sergei404\Actions\CancelAction";
    // const ACTION_ANSWER = "\Sergei404\Actions\AnswerAction";
    // const ACTION_PERFORM = "\Sergei404\Actions\PerformAction";
    // const ACTION_REFUSE = "\Sergei404\Actions\RefuseAction";
    const ACTION_CANCEL = "cancel";
    const ACTION_ANSWER = "answer";
    const ACTION_PERFORM = "perform";
    const ACTION_REFUSE = "refuse";

    private static $statuses = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_PERFORMED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
    ];

    private static $actions = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_ANSWER => 'Откликнуться',
        self::ACTION_PERFORM => 'Выполнить',
        self::ACTION_REFUSE => 'Отказаться'
    ];

    private static $statusesWithActions = [
        self::STATUS_NEW => [self::ACTION_ANSWER, self::ACTION_CANCEL],
        self::STATUS_CANCELED => [],
        self::STATUS_IN_WORK => [self::ACTION_PERFORM, self::ACTION_REFUSE],
        self::STATUS_PERFORMED => [],
        self::STATUS_FAILED => []
    ];

    private static $actionsWithStatuses = [
        self::ACTION_CANCEL => self::STATUS_CANCELED,
        self::ACTION_ANSWER => self::STATUS_IN_WORK,
        self::ACTION_PERFORM => self::STATUS_PERFORMED,
        self::ACTION_REFUSE => self::STATUS_FAILED
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
            echo "значение $currentStatus некорректно";
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
     * вщзвращает id заказчика
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
     * Возвращает список доступных действий.
     *
     * @return array Массив действий
     */
    public function getAvailableActions(): array
    {
        $actions = self::$statusesWithActions[$this->currentStatus];

        $actionObjectList = [];
        foreach ($actions as $action) {
            $name = 'Sergei404\Actions\\' . lcfirst($action) . 'Action';
            $actionObjectList[] = new $name();
        }

        return $actionObjectList;
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
        return '';
    }
}
