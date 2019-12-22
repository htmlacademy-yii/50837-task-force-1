<?php

namespace TaskForce\Actions;

abstract class ActionAbstract {
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @return string
	 */
	abstract public function getName(): string ;
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @return string
	 */
	abstract public function getCode(): string;
	
	/**
	 * @param int $executorId
	 * @param int $customerId
	 * @param int $currentUserId
	 *
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @return bool
	 */
	abstract public function isAllowed(int $executorId, int $customerId, int $currentUserId): bool;
}
