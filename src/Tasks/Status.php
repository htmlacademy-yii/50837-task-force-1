<?php

namespace TaskForce\Tasks;


class Status {
	const STATUS_NEW         = 'new';
	const STATUS_CANCELLED   = 'cancelled';
	const STATUS_IN_PROGRESS = 'in_progress';
	const STATUS_DONE        = 'done';
	const STATUS_FAILED      = 'failed';
	
	const ACTION_CANCEL  = 'cancel';
	const ACTION_RESPOND = 'respond';
	const ACTION_DONE    = 'done';
	const ACTION_REFUSE  = 'refuse';
	
	const ACTION_TO_STATUS_MAP = [
		self::ACTION_CANCEL  => self::STATUS_CANCELLED,
		self::ACTION_RESPOND => self::STATUS_IN_PROGRESS,
		self::ACTION_DONE    => self::STATUS_DONE,
		self::ACTION_REFUSE  => self::STATUS_FAILED
	];
	
	const STATUS_TO_ACTIONS_MAP = [
		self::STATUS_NEW         => [self::ACTION_CANCEL, self::ACTION_RESPOND],
		self::STATUS_CANCELLED   => [],
		self::STATUS_IN_PROGRESS => [self::ACTION_DONE, self::ACTION_REFUSE],
		self::STATUS_DONE        => [],
		self::STATUS_FAILED      => []
	];
	
	/** @var int */
	protected $executorId;
	
	/** @var int */
	protected $customerId;
	
	/**
	 * Task constructor
	 *
	 * @param int $executorId
	 * @param int $customerId
	 */
	public function __construct(int $executorId, int $customerId) {
		$this->executorId = $executorId;
		$this->customerId = $customerId;
	}
	
	/**
	 * @param string $action
	 *
	 * @return string
	 */
	public function getStatusByAction(string $action): string {
		assert(in_array($action, array_keys(self::ACTION_TO_STATUS_MAP)));
		
		return self::ACTION_TO_STATUS_MAP[$action];
	}
	
	/**
	 * @param string $status
	 *
	 * @return array
	 */
	public function getAvailableActionsForStatus(string $status): array {
		assert(in_array($status, array_keys(self::STATUS_TO_ACTIONS_MAP)));
		
		return self::STATUS_TO_ACTIONS_MAP[$status];
	}
}
