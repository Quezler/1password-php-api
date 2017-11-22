#!/usr/bin/env php
<?php

//namespace App;

use Quezler\OnePasswordPhpApi\Console\DefaultCommand;
use Symfony\Component\Console\Application;

require __DIR__.'/vendor/autoload.php';

(new Application('1password php api', 'v0.0.0'))
    ->add(new DefaultCommand)
    ->getApplication()
//    ->setDefaultCommand('command:default', true)
    ->run();
