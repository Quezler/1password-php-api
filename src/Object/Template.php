<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Quezler\OnePasswordPhpApi\OP;
use Quezler\OnePasswordPhpApi\Traits\HasUuid;
use stdClass;

class Template
{
    use HasUuid;

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
}
