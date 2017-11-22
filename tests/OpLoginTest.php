<?php

namespace Tests;

use Dotenv\Dotenv;
use LogicException;
use PHPUnit\Framework\TestCase;
use Quezler\OnePasswordPhpApi\OP;

class OpLoginTest extends TestCase
{
    function test_constructor_throws_exception() {

        $dotenv = new Dotenv(__DIR__, '/../.env.example');
        $dotenv->overload();

        $this->expectException(LogicException::class);

        (new OP);
    }

    function test_constructor_throws_no_exception() {
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->overload();

        $op = (new OP);

        self::assertNotNull($op->getSession());
    }
}
