<?php

require_once "Task.php";

$task = new Task(1, 2);

foreach (Task::STATUS_TO_ACTIONS_MAP as $status => $actions) {
	echo "Для статуса '$status' доступны следующие действия: " . implode(', ', $task->getAvailableActionsForStatus($status)) . "<br/>";
}

foreach (Task::ACTION_TO_STATUS_MAP as $action => $status) {
	echo "При выборе действия '$action', задание перейдет в статус {$task->getStatusByAction($action)} <br/>";
}
