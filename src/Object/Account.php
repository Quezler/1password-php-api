<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Carbon\Carbon;
use stdClass;

class Account
{
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

    function __construct(stdClass $object)
    {
        foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }

        $this->createdAt = new Carbon($this->createdAt);
    }
}
