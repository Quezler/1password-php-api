<?php

namespace Quezler\OnePasswordPhpApi;

class OP
{
    public static function getExecutablePath() {
        return Package::getBasePath() . '/executable/op';
    }
}
