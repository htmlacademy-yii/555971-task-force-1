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

    //TODO пока нигде не используется
    const ROLE_OWNER = 'owner';
    const ROLE_DOER = 'doer';

    //TODO пока нигде не используется
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


    public function __construct(array $properties)
    {
        foreach ($properties as $name => $value) {

            if (property_exists(get_class($this), $name)) {
                $this->{$name} = $value;
            }

        }
    }

    //TODO пока нигде не используется
    public static function getAllStatuses()
    {
        return self::ALL_STATUSES;
    }


    public static function getAllActions()
    {

        return array_keys(self::VALID_STATUSES);

    }


    private function isValidAction($action)
    {
        $allActions = self::getAllActions();
        $validStatus = self::VALID_STATUSES[$action] ?? null;

        return (in_array($action, $allActions) &&  $this->status==$validStatus);
    }

    //TODO пока нигде не используется
    public function getNextStatus($action)
    {
        if ($this->isValidAction($action)) {

            return self::NEXT_STATUSES[$action];

        } else {

            throw new Exception('"' . $action. '" is not valid action for status "'. $this->status. '"');

        }
    }

}
