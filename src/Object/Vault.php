<?php

namespace Quezler\OnePasswordPhpApi\Object;

class Vault
{
    /**
     * @var string
     */
    private $uuid;

    function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }
}
