<?php

namespace Quezler\OnePasswordPhpApi\Traits;

trait HasUuid
{
    /**
     * @var string|null
     */
    private $uuid;

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }
}
