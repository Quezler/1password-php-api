<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Quezler\OnePasswordPhpApi\OP;
use Quezler\OnePasswordPhpApi\Traits\HasDetails;
use Quezler\OnePasswordPhpApi\Traits\HasUuid;

class Vault
{
    use HasUuid, HasDetails;
    /**
     * @var OP
     */
    private $op;

//    private $name;
//    private $type;
//    private $desc;
//    private $color;
//    private $avatar;

    function __construct(OP $op, string $uuid)
    {
        $this->op = $op;
        $this->uuid = $uuid;
    }

//    public function getDetails() {
//        $object = $this->op->command("get vault {$this->uuid}");
//
//        $object->avatar = new Avatar($this->op, $object->avatar);
//
//        return $object;
//    }
}
