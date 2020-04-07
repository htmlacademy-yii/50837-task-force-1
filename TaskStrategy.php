<?php

class TaskStrategy
{
    // статусы
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in work';
    const STATUS_PERFORMED = 'performed';
    const STATUS_FAILED = 'failed';

    //действия
    const ACTION_CANSEL = 'cansel';
    const ACTION_ANSWER = 'answer';
    const ACTION_PERFORM = 'perform';
    const ACTION_REFUSE = 'refuse';

    const STATUSES = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_PERFORMED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
    ];

    const ACTIONS = [
        self::ACTION_CANSEL => 'Отменить',
        self::ACTION_ANSWER => 'Откликнуться',
        self::ACTION_PERFORM => 'Выполнить',
        self::ACTION_REFUSE => 'Отказаться'
    ];

    public $statusesWithActions = [
        self::STATUS_NEW => [self::ACTION_CANSEL, self::ACTION_ANSWER],
        self::STATUS_CANCELED => [],
        self::STATUS_IN_WORK => [self::ACTION_PERFORM, self::ACTION_REFUSE],
        self::STATUS_PERFORMED => [],
        self::STATUS_FAILED => []
    ];

    public $actionsWithStatuses = [
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
        $this->currentStatus = $currentStatus;
    }

    public function setCurrentStatus(string $currentStatus) {
        $this->currentStatus = $currentStatus;
    }

    public function getCurrentStatus() {
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

    public function getAvailableActions(string $status): array
    {
        if(array_key_exists($status, $this->statusesWithActions)) {
            return $this->statusesWithActions[$status];
        }
        return [];
    }

    public function getNextStatus(string $action): string
    {

        if(array_key_exists($action, $this->actionsWithStatuses)) {
            return $this->actionsWithStatuses[$action];
        }
        return '';
    }
}

