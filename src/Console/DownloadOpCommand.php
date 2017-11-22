<?php

namespace Quezler\OnePasswordPhpApi\Console;

use GuzzleHttp\Client;
use Quezler\OnePasswordPhpApi\Executable;
use Quezler\OnePasswordPhpApi\OP;
use Quezler\OnePasswordPhpApi\Package;
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

        $output->writeln('');

        $html = (new Client)->get(self::releases)->getBody()->getContents();

        $crawler = new Crawler($html);

        $releases = $crawler->filter('article[id]');

        $mostRecentRelease = $releases->first();

        $downloads = $mostRecentRelease->filter('a[href]');

        $download = $this->getCompatibleDownload($downloads);

        $output->writeln('');

//        $download = null;

        if (is_null($download)) {
            $output->writeln('<error>No compatible download found :(</error>');
        }

        $zip = (new Client)->get($download)->getBody()->getContents();

        file_put_contents(Package::getBasePath() . '/executable/op.zip', $zip);

        $zip = new \ZipArchive;
        $zip->open(Package::getBasePath() . '/executable/op.zip');
        $zip->extractTo(Package::getBasePath() . '/executable');
        $zip->close();

        chmod(Package::getBasePath() . '/executable/op', 0777);

        $output->writeln('<info>Executable saved as <comment>'. Package::getBasePath() . '/executable/op' .'</comment>.</info>');
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

    private function getCompatibleDownload(Crawler $downloads) {

        $return = null;

        $downloads->each(function (Crawler $anchor) use (&$return) {
            $href = $anchor->attr('href');
            $compatible = $this->downloadIsCompatible($href);

            if ($compatible) {
                $this->output->writeln("<info>{$href}</info>");
                $return = $href;
            } else {
                $this->output->writeln("<comment>{$href}</comment>");
            }
        });

        return $return;
    }

    private function downloadIsCompatible(string $href): bool {

        $match = strtr('op_os_architecture', [
            'os' => $this->os,
            'architecture' => ($this->architecture === 64 ? 'amd64' : '386'),
        ]);

        return strpos($href, $match) !== false;
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
