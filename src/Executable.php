<?php

namespace Quezler\OnePasswordPhpApi;

use Symfony\Component\Console\Input\ArrayInput;

class Executable
{
    /**
     * @var OP
     */
    private $op;

    function __construct(OP $op)
    {
        $this->op = $op;
    }

    public function getPath() {
        return Package::getBasePath() . '/executable/op';
    }

    public function command(string $command, array $arguments) {

        $arguments = (new ArrayInput($arguments))->__toString();

        $cmd = "{$this->op->getSession()->getExport()} && {$this->getPath()} {$command} {$arguments}";

        exec($cmd, $output);

        return \GuzzleHttp\json_decode($output[0]);
    }
}
