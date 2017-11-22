<?php

namespace Quezler\OnePasswordPhpApi\Console;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

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

    /**
     * @var string
     */
    private $os;

    /**
     * @var integer
     */
    private $architecture;

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
        $this->detectBinaryArchitecture();
//        $this->getReleases();

        $html = (new Client)->get(self::releases)->getBody()->getContents();

        $crawler = new Crawler($html);

        $releases = $crawler->filter('article[id]');

        $mostRecentRelease = $releases->first();

        $downloads = $mostRecentRelease->filter('a[href]');

        $downloads->each(function (Crawler $anchor) {
            dump($anchor->attr('href'));
        });

        /**
        "#v11001"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_darwin_386_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_darwin_amd64_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_freebsd_386_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_freebsd_amd64_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_freebsd_arm_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_linux_386_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_linux_amd64_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_linux_arm_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_netbsd_386_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_netbsd_amd64_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_netbsd_arm_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_openbsd_386_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_openbsd_amd64_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_windows_386_v0.1.1.zip"
        "https://cache.agilebits.com/dist/1P/op/pkg/v0.1.1/op_windows_amd64_v0.1.1.zip"
         */
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

    /**
     * Find out if this device is 32 or 64 bit, to download '386' or 'amd64' respectively.
     *
     * https://stackoverflow.com/questions/5423848/checking-if-your-code-is-running-on-64-bit-php
     */
    private function detectBinaryArchitecture() {
        $this->architecture = PHP_INT_SIZE * 8; // 32 or 64

        $this->output->writeln("<info>Architecture detected as <comment>{$this->architecture}</comment> bit.</info>");
    }

//    private function getReleases() {
//        $html = (new Client)->get(self::releases)->getBody()->getContents();
//
//        $crawler = new Crawler($html);
//
//        $releases = $crawler->filter('article[id]');
//
//        $mostRecentRelease = $releases->first();
//
//        dump($mostRecentRelease->html());
//
////        $releases->each(function (Crawler $article) {
////            dump($article->filter('h3')->text());
////        });
//    }
}
