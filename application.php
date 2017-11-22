#!/usr/bin/env php
<?php

//namespace App;

use Quezler\OnePasswordPhpApi\Console\DefaultCommand;
use Quezler\OnePasswordPhpApi\Console\DownloadOpCommand;
use Symfony\Component\Console\Application;

require __DIR__.'/vendor/autoload.php';

(new Application('1password php api', 'v0.0.0'))
    ->add(new DefaultCommand)
    ->getApplication()
    ->add(new DownloadOpCommand)
    ->getApplication()
//    ->setDefaultCommand('command:default', true)
    ->run();
