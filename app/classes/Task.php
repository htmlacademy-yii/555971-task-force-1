<?php

namespace App\classes;
use \Exception;

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

    //TODO пока нигде не используется
    const ROLE_OWNER = 'owner';
    const ROLE_DOER = 'doer';

    const ALL_STATUSES = [
        self::STATUS_NEW,
        self::STATUS_CANCELED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_FAILED,
        self::STATUS_DONE
    ];

    const VALID_STATUSES = [
        self::ACTION_CANCEL => self::STATUS_NEW,
        self::ACTION_RESPOND => self::STATUS_NEW,
        self::ACTION_ASSIGN_DOER => self::STATUS_NEW,
        self::ACTION_FAIL => self::STATUS_IN_PROGRESS,
        self::ACTION_MARK_DONE => self::STATUS_IN_PROGRESS,
    ];

    const NEXT_STATUSES = [
        self::ACTION_CANCEL => self::STATUS_CANCELED,
        self::ACTION_RESPOND => self::STATUS_NEW,
        self::ACTION_ASSIGN_DOER => self::STATUS_IN_PROGRESS,
        self::ACTION_FAIL => self::STATUS_FAILED,
        self::ACTION_MARK_DONE => self::STATUS_DONE
    ];

    private $status;

    //TODO пока нигде не используются
    private $owner_id;
    private $doer_id;
    private $expires_at;

    /**
     * Task constructor.
     *
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        foreach ($properties as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    /**
     * Return all statuses
     *
     * @return array
     */
    public static function getAllStatuses()
    {
        return self::ALL_STATUSES;
    }

    /**
     * Return all actions
     *
     * @return array
     */
    public static function getAllActions()
    {
        return array_keys(self::VALID_STATUSES);
    }

    /**
     * Check current status exists
     *
     * @return bool
     */
    private function isStatusExists()
    {
        return in_array($this->status, self::getAllStatuses());
    }

    /**
     * Check action exists
     *
     * @param string $action
     * @return bool
     */
    private function isActionExists($action)
    {
        return in_array($action, self::getAllActions());
    }

    /**
     * Validate action depend on current status
     *
     * @param string $action
     * @return bool
     */
    private function isValidAction($action)
    {
        $validStatus = self::VALID_STATUSES[$action] ?? null;
        return ($this->status == $validStatus);
    }

    //TODO пока нигде не используется
    /**
     * @param $action
     * @return mixed
     * @throws Exception
     */
    public function getNextStatus($action)
    {
        if (!$this->isStatusExists()) {
            throw new Exception("status `{$this->status}` not exist");
        }
        if (!$this->isActionExists($action)) {
            throw new Exception("action `{$action}` not exist");
        }
        if (!$this->isValidAction($action)) {
            throw new Exception("`{$action}` is not valid action for status `{$this->status}`");
        }
        return self::NEXT_STATUSES[$action];
    }
}
