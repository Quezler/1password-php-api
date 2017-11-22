<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Quezler\OnePasswordPhpApi\Object\Account;
use Quezler\OnePasswordPhpApi\Object\Avatar;
use Quezler\OnePasswordPhpApi\OP;

class OpTest extends TestCase
{
    /**
     * @var OP
     */
    public $op;

    protected function setUp()
    {
        parent::setUp();

        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();

        $this->op = (new OP);
    }

    function test_all() {
        $this->vaults();
        $this->account();
    }

    function vaults() {
        $vaults = $this->op->getVaults();
        self::assertNotEmpty($vaults);

        foreach ($vaults as $vault) {
            $details = $vault->getDetails();
            self::assertNotEmpty($details);
            self::assertInstanceOf(Avatar::class, $details->avatar);
            self::assertNotEmpty($details->avatar->getSrc());
        }
    }

    function account() {
        $account = $this->op->getAccount();
        self::assertInstanceOf(Account::class, $account);
        self::assertNotEmpty($account->avatar->getSrc());
    }
}
