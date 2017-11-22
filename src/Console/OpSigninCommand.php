<?php

namespace Quezler\OnePasswordPhpApi\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OpSigninCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('op:signin')

            ->setDescription('The op signin command authenticates the credentials with 1Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('...');
    }
}
