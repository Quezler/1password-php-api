<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Quezler\OnePasswordPhpApi\OP;
use Quezler\OnePasswordPhpApi\Traits\HasUuid;
use stdClass;

class Item
{
    use HasUuid;

    /**
     * @var OP
     */
    private $op;

    /**
     * @var Vault
     */
    private $vault;

    function __construct(OP $op, stdClass $object)
    {
        $this->op = $op;

        $this->vault = new Vault($op, $object->vaultUuid);
        unset($object->vaultUuid);

        foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }
    }
}
