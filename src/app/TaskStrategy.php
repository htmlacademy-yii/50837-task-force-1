<?php

namespace Sergei404;

use Sergei404\Actions\AnswerAction;
use Sergei404\Actions\CancelAction;

class TaskStrategy
{
    // статусы
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in work';
    const STATUS_PERFORMED = 'performed';
    const STATUS_FAILED = 'failed';

    //действия
    // const ACTION_CANSEL = 'cancel';
    const ACTION_CANSEL = 'Sergei404\action\CancelAction';
    const ACTION_ANSWER = 'answer';
    const ACTION_PERFORM = 'perform';
    const ACTION_REFUSE = 'refuse';

    private static $statuses = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_PERFORMED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
    ];

    private static $actions = [
        self::ACTION_CANSEL => 'Отменить',
        self::ACTION_ANSWER => 'Откликнуться',
        self::ACTION_PERFORM => 'Выполнить',
        self::ACTION_REFUSE => 'Отказаться'
    ];

    private static $statusesWithActions = [
        self::STATUS_NEW => [self::ACTION_CANSEL, self::ACTION_ANSWER],
        self::STATUS_CANCELED => [],
        self::STATUS_IN_WORK => [self::ACTION_PERFORM, self::ACTION_REFUSE],
        self::STATUS_PERFORMED => [],
        self::STATUS_FAILED => []
    ];

    private static $actionsWithStatuses = [
        self::ACTION_CANSEL => self::STATUS_CANCELED,
        self::ACTION_ANSWER => self::STATUS_IN_WORK,
        self::ACTION_PERFORM => self::STATUS_PERFORMED,
        self::ACTION_REFUSE => self::STATUS_FAILED
    ];

    //id заказчика и исполнителя
    private $idCustomer;
    private $idExecutor;
    private $currentStatus;

    function __construct(string $idCustomer, string $idExecutor, string $currentStatus)
    {
        $this->idCustomer = $idCustomer;
        $this->idExecutor = $idExecutor;
        if (array_key_exists($currentStatus, self::$statusesWithActions)) {
            $this->currentStatus = $currentStatus;
        } else {
            echo "значение $currentStatus некорректно";
        }
    }


    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    public function getIdExecutor()
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
            $name = ucfirst($action) . 'Action';
            $name = "Sergei404\Actions\AnswerAction";
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
