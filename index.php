<?php

require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\Tasks\Status;

$task = new Status(1, 2);

foreach (Status::STATUS_TO_ACTIONS_MAP as $status => $actions) {
	echo "Для статуса '$status' доступны следующие действия: " . implode(', ', $task->getAvailableActionsForStatus($status)) . "<br/>";
}

foreach (Status::ACTION_TO_STATUS_MAP as $action => $status) {
	echo "При выборе действия '$action', задание перейдет в статус {$task->getStatusByAction($action)} <br/>";
}
