<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Quezler\OnePasswordPhpApi\OP;
use Quezler\OnePasswordPhpApi\Traits\HasDetails;
use Quezler\OnePasswordPhpApi\Traits\HasUuid;
use stdClass;

class Template
{
    use HasUuid, HasDetails;

    /**
     * @var OP
     */
    private $op;

    /**
     * @var string
     */
    private $name;

    function __construct(OP $op, stdClass $object)
    {

        $this->op = $op;
        $this->uuid = $object->uuid;
        $this->name = $object->name;
    }

    private function fetchDetails() {
        return $this->op->cast(
            $this->op->command("get ". strtolower((new \ReflectionClass($this))->getShortName()) ." {$this->name}")
        );
    }
}
