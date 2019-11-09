<?php

/**
 * Class Task
 */
class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_FAILED = 'failed';
    const STATUS_DONE = 'done';

    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_ASSIGN_DOER = 'assign doer';
    const ACTION_FAIL = 'fail';
    const ACTION_MARK_DONE = 'mark done';

    const ROLE_OWNER = 'owner';
    const ROLE_DOER = 'doer';

    private $owner_id;
    private $doer_id;
    private $status;
    private $tm_expire;

    private static $statuses = [
        self::STATUS_NEW,
        self::STATUS_CANCELED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_FAILED,
        self::STATUS_DONE
    ];

    private static $actions = [
        self::ACTION_CANCEL,
        self::ACTION_RESPOND,
        self::ACTION_ASSIGN_DOER,
        self::ACTION_FAIL,
        self::ACTION_MARK_DONE
    ];

    public function __construct($owner_id, $status, $tm_expire=null, $doer_id=null)
    {
        $this->owner_id = $owner_id;
        $this->doer_id = $doer_id;
        $this->status = $status;
        $this->tm_expire = $tm_expire;
    }

    public static function getAllStatuses()
    {
        return self::$statuses;
    }

    public static function getAllActions()
    {
        return self::$actions;
    }

    public function getNextStatus($action)
    {
        if ($this->status == self::STATUS_NEW  &&  $action == self::ACTION_CANCEL) {
            return self::STATUS_CANCELED;
        } elseif ($this->status == self::STATUS_NEW  &&  $action == self::ACTION_RESPOND) {
            return $this->status;
        } elseif ($this->status == self::STATUS_NEW  &&  $action == self::ACTION_ASSIGN_DOER) {
            return self::STATUS_IN_PROGRESS;
        } elseif ($this->status == self::STATUS_IN_PROGRESS  &&  $action == self::ACTION_FAIL) {
            return self::STATUS_FAILED;
        } elseif ($this->status == self::STATUS_IN_PROGRESS  && $action == self::ACTION_MARK_DONE) {
            return self::STATUS_DONE;
        } else {
            return null;
        }
    }

    public function getStatus()
    {
        return $this->status;
    }
}
