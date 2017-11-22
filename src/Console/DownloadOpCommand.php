<?php

namespace Quezler\OnePasswordPhpApi\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadOpCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('download:op')

            ->setDescription('Download 1password CLI application from https://app-updates.agilebits.com/product_history/CLI')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //
    }
}
