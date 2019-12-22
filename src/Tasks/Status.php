<?php

namespace TaskForce\Tasks;

use \LogicException;
use TaskForce\Actions\CancelAction;
use TaskForce\Actions\DoneAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;

class Status {
	const STATUS_CANCELED    = 1;
	const STATUS_IN_PROGRESS = 2;
	const STATUS_DONE        = 3;
	const STATUS_FAILED      = 4;
	const STATUS_NEW         = 5;
	
	const ACTION_CANCEL  = 1;
	const ACTION_RESPOND = 2;
	const ACTION_DONE    = 3;
	const ACTION_REFUSE  = 4;
	
	const ACTION_TO_STATUS_MAP = [
		self::ACTION_CANCEL  => self::STATUS_CANCELED,
		self::ACTION_RESPOND => self::STATUS_IN_PROGRESS,
		self::ACTION_DONE    => self::STATUS_DONE,
		self::ACTION_REFUSE  => self::STATUS_FAILED
	];
	
	const STATUS_TO_ACTIONS_MAP = [
		self::STATUS_NEW         => [CancelAction::class, RespondAction::class],
		self::STATUS_CANCELED    => [],
		self::STATUS_IN_PROGRESS => [DoneAction::class, RefuseAction::class],
		self::STATUS_DONE        => [],
		self::STATUS_FAILED      => []
	];
	
	/** @var int */
	protected $executorId;
	
	/** @var int */
	protected $customerId;
	
	/** @var int */
	protected $currentUserId;
	
	/**
	 * Status constructor.
	 *
	 * @param int $executorId
	 * @param int $customerId
	 * @param int $currentUserId
	 */
	public function __construct(int $executorId, int $customerId, int $currentUserId) {
		$this->executorId    = $executorId;
		$this->customerId    = $customerId;
		$this->currentUserId = $currentUserId;
	}
	
	/**
	 * @param string $action
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @return string
	 * @throws LogicException
	 */
	public function getStatusByAction(string $action): string {
		if (! isset(self::ACTION_TO_STATUS_MAP[$action])) {
			throw new LogicException('Unhandled action type');
		}
		
		return self::ACTION_TO_STATUS_MAP[$action];
	}
	
	/**
	 * @param string $status
	 *
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @return array
	 * @throws LogicException
	 */
	public function getAvailableActionsForStatus(string $status): array {
		$actionsOfStatus = self::STATUS_TO_ACTIONS_MAP[$status];
		$actions         = [];
		
		if (! empty($actionsOfStatus)) {
			foreach ($actionsOfStatus as $actionClassName) {
				if (! class_exists($actionClassName)) {
					throw new LogicException('Action class not found');
				}
				
				$actions[] = new $actionClassName();
			}
		}
		
		return $actions;
	}
}
