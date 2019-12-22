<?php

namespace TaskForce\Actions;

use TaskForce\Tasks\Status;

class RefuseAction extends ActionAbstract {
	
	/**
	 * @return string
	 */
	public function getName(): string {
		return 'Отказаться';
	}
	
	/**
	 * @return string
	 */
	public function getCode(): string {
		return Status::ACTION_REFUSE;
	}
	
	/**
	 * @param int $executorId
	 * @param int $customerId
	 * @param int $currentUserId
	 *
	 * @return bool
	 */
	public function isAllowed(int $executorId, int $customerId, int $currentUserId): bool {
		return $executorId === $currentUserId;
	}
}
