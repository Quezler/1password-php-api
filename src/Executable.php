<?php

namespace Quezler\OnePasswordPhpApi;

class Executable
{
    /**
     * @var OP
     */
    private $op;

    function __construct(OP $op)
    {
        $this->op = $op;
    }

    public function getPath() {
        return Package::getBasePath() . '/executable/op';
    }
}
