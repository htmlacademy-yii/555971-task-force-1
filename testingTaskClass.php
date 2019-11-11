<?php
require_once 'vendor/autoload.php';

use App\classes\Task;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$task1 = new Task(['status' => Task::STATUS_NEW ]);

assert($task1->getNextStatus(Task::ACTION_CANCEL) == Task::STATUS_CANCELED, 'new, cancel');
assert($task1->getNextStatus(Task::ACTION_RESPOND) == Task::STATUS_NEW , 'new, respond');
assert($task1->getNextStatus(Task::ACTION_ASSIGN_DOER) == Task::STATUS_IN_PROGRESS, 'new, assign doer');

/**
 * Если раскомментировать по очереди закомменитрованные строки, то будут появляться разные Exception
 */

//assert($task1->getNextStatus(Task::ACTION_FAIL) == null, 'new, fail');

$task2 = new Task(['status' => Task::STATUS_IN_PROGRESS]);

assert($task2->getNextStatus(Task::ACTION_FAIL) == Task::STATUS_FAILED, 'in progress, fail');
assert($task2->getNextStatus(Task::ACTION_MARK_DONE) == Task::STATUS_DONE, 'in progress, mark done');

//assert($task2->getNextStatus('bar') == Task::STATUS_DONE, 'in progress, mark done');

//assert($task2->getNextStatus(Task::ACTION_ASSIGN_DOER) == null, 'in_progress, assign doer');

/*
$task3 = new Task(['status' => 'foo']);
assert($task3->getNextStatus(Task::ACTION_CANCEL) == Task::STATUS_CANCELED, 'new, cancel');*/
