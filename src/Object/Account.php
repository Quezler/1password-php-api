<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Carbon\Carbon;
use Quezler\OnePasswordPhpApi\OP;
use stdClass;

class Account
{
    private $op;

    public $uuid;
    public $type;
    public $state;
    public $createdAt;
    public $name;
    public $attrVersion;
    public $userVersion;
    public $language;
    public $avatar;
    public $baseAvatarURL;
    public $baseAttachmentURL;

    function __construct(OP $op, stdClass $object)
    {
        $this->op = $op;

        foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }

        $this->createdAt = new Carbon($this->createdAt);
        $this->avatar = new Avatar($this->op, $this->avatar);
    }
}
