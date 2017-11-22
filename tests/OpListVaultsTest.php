<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Quezler\OnePasswordPhpApi\OP;

class OpListVaultsTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->overload();
    }

    function test_vault_list_and_detail() {
        $op = (new OP);

        self::assertNotEmpty($op->getVaults());

        foreach ($op->getVaults() as $vault) {
            self::assertNotEmpty($vault->getDetails());
        }
    }
}
