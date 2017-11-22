<?php

namespace Quezler\OnePasswordPhpApi\Console;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadOpCommand extends Command
{
    const releases = 'https://app-updates.agilebits.com/product_history/CLI';

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    private $os;

    protected function configure()
    {
        $this
            ->setName('download:op')

            ->setDescription('Download 1password CLI application from '. self::releases)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->detectOperatingSystem();
        $this->getReleases();
    }

    /**
     * Find out the name of the operating system, in order to download the right CLI build.
     */
    private function detectOperatingSystem() {
        $osRaw = php_uname('s'); // 's': Operating system name. eg. FreeBSD.
        $osLow = strtolower($osRaw);

        $this->output->writeln("<info>OS detected as <comment>{$osRaw} ($osLow)</comment>.</info>");

        $this->os = $osLow;
    }

    private function getReleases() {
        $html = (new Client)->get(self::releases)->getBody()->getContents();

        dump($html);
    }
}
