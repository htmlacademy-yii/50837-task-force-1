<?php

namespace TaskForce\Actions;

use TaskForce\Tasks\Status;

class DoneAction extends ActionAbstract {
	
	/**
	 * @return string
	 */
	public function getName(): string {
		return 'Выполнено';
	}
	
	/**
	 * @return string
	 */
	public function getCode(): string {
		return Status::ACTION_DONE;
	}
	
	/**
	 * @param int $executorId
	 * @param int $customerId
	 * @param int $currentUserId
	 *
	 * @return bool
	 */
	public function isAllowed(int $executorId, int $customerId, int $currentUserId): bool {
		return $customerId === $currentUserId;
	}
}
