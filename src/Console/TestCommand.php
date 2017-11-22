<?php

namespace Quezler\OnePasswordPhpApi\Console;

use Quezler\OnePasswordPhpApi\Object\Template;
use Quezler\OnePasswordPhpApi\OP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('test')

            ->setDescription('Test stuff.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $op = (new OP);

        $vault = $op->getVault('tmp');

        $template = $op->getTemplates()->filter(function (Template $template) {
            return $template->getDetails()->name == 'Password';
        })->filter();

//        dump($vault);
        dump($template);
    }
}
