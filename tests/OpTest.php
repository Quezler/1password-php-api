<?php

namespace Tests;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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

        $avatar = $account->avatar;
        self::assertNotEmpty($avatar->getSrc());

        $status = (new Client)->get($avatar->getSrc())->getStatusCode();

        self::assertEquals(200, $status);

        try {
            $status = (new Client)->get($avatar->getSrc(). 'nope')->getStatusCode();
        } catch (ClientException $exception) {
            $status = $exception->getResponse()->getStatusCode();
        }

        self::assertEquals(403, $status);
    }
}
