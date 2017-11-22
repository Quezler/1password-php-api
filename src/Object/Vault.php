<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Quezler\OnePasswordPhpApi\OP;

class Vault
{
    /**
     * @var OP
     */
    private $op;

    /**
     * @var string
     */
    private $uuid;

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

    public function getDetails() {
        return $this->op->command("get vault {$this->uuid}");
    }
}
