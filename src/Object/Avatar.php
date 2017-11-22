<?php

namespace Quezler\OnePasswordPhpApi\Object;

use Quezler\OnePasswordPhpApi\OP;

class Avatar
{
    /**
     * @var OP
     */
    private $op;
    /**
     * @var string
     */
    private $filename;

    function __construct(OP $op, string $filename)
    {
        $this->op = $op;
        $this->filename = $filename;
    }

    public function getSrc() {
        return $this->op->getAccount()->baseAvatarURL . $this->op->getAccount()->getUuid() .'/'.$this->filename;
    }
}
