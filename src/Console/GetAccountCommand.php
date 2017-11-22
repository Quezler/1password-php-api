<?php

namespace Quezler\OnePasswordPhpApi\Console;

use Quezler\OnePasswordPhpApi\OP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetAccountCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('op:get:account')

            ->setDescription('Get 1password account.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $op = (new OP);

        dump(
            $op->getAccount()
        );
    }
}
