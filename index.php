<?php
require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\Tasks\Status;
use TaskForce\Actions\ActionAbstract;

$task = new Status(1, 2, 1);

foreach (Status::STATUS_TO_ACTIONS_MAP as $status => $actions) {
	$availableActions = $task->getAvailableActionsForStatus($status);
	
	if (! empty($availableActions)) {
		echo "Для статуса '$status' доступны следующие действия: <br/>";
		
		/** @var ActionAbstract $action */
		foreach ($availableActions as $action) {
			echo $action->getName() . "<br/>";
		}
	} else {
		echo "Для статуса '$status' нет доступных действий <br/>";
	}
}

foreach (Status::ACTION_TO_STATUS_MAP as $action => $status) {
	echo "При выборе действия '$action', задание перейдет в статус {$task->getStatusByAction($action)} <br/>";
}
