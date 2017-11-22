<?php

namespace Quezler\OnePasswordPhpApi\Traits;

use ReflectionClass;

trait HasDetails
{
    private $details;

    public function getDetails() {
        return $this->details ?: $this->details = $this->fetchDetails();
    }

    public function setDetails($details)
    {
        $this->details = $details;
    }

    private function fetchDetails() {
        return $this->op->cast(
            $this->op->command("get ". strtolower((new ReflectionClass($this))->getShortName()) ." {$this->uuid}")
        );
    }
}
