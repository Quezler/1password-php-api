<?php

namespace Quezler\OnePasswordPhpApi\Console;

use Quezler\OnePasswordPhpApi\OP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListVaultsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('op:list:vaults')

            ->setDescription('List 1password vaults.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $op = (new OP);

        foreach ($op->getVaults() as $vault) {
            dump(
                $vault->getDetails()
            );
        }
    }
}
