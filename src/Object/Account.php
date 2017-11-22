<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Carbon\Carbon;
use Quezler\OnePasswordPhpApi\OP;
use Quezler\OnePasswordPhpApi\Traits\HasUuid;
use stdClass;

class Account
{
    use HasUuid;

    private $op;

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

        $object = $op->cast($object);

        foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }
    }
}
