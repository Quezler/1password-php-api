#!/usr/bin/env php
<?php

//namespace App;

use Quezler\OnePasswordPhpApi\Console\DefaultCommand;
use Quezler\OnePasswordPhpApi\Console\DownloadOpCommand;
use Quezler\OnePasswordPhpApi\Console\GetAccountCommand;
use Quezler\OnePasswordPhpApi\Console\ListVaultsCommand;
use Quezler\OnePasswordPhpApi\Console\OpSigninCommand;
use Symfony\Component\Console\Application;

require __DIR__.'/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$app = (new Application('1password php api', 'v0.0.0'));

$app->add(new DefaultCommand);
$app->add(new DownloadOpCommand);
$app->add(new OpSigninCommand);
$app->add(new ListVaultsCommand);
$app->add(new GetAccountCommand);

$app->run();
