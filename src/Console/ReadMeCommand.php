<?php

namespace Quezler\OnePasswordPhpApi\Console;

use Quezler\OnePasswordPhpApi\Object\Vault;
use Quezler\OnePasswordPhpApi\OP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReadMeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('read:me')

            ->setDescription('I should be the first command you run!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $op = (new OP);

        $account = $op->getAccount();

        $output->writeln("<info>Hello there, <comment>{$account->name}</comment>!</info>");
        $output->writeln("<info>How's your 1password experience so far? You made your account <comment>{$account->createdAt->diffForHumans()}</comment>.</info>");

        $output->writeln('');

        $vaults = $op->getVaults();

        $output->writeln("<info>Anyways, lets get down to business, since we have to talk about your <comment>{$vaults->count()}</comment> vaults.</info>");

        $vaultnames = $vaults->map(function (Vault $vault) {
            return $vault->getDetails()->name;
        })->toArray();

        // https://stackoverflow.com/questions/8586141/implode-array-with-and-add-and-before-last-item
        $vaultnames = $this->implodeCommaCommaAmpersand($vaultnames);

        $output->writeln("<info><comment>{$vaultnames}</comment> if i recall correctly.</info>");

        $vaultsizes = $vaults->map(function (Vault $vault) use ($op) {
            return $op->getItems($vault)->count();
        })->toArray();

        $vaultsizes = $this->implodeCommaCommaAmpersand($vaultsizes);

        $output->writeln("<info>And they have <comment>{$vaultsizes}</comment> items inside them respectively.</info>");
    }

    // https://stackoverflow.com/questions/8586141/implode-array-with-and-add-and-before-last-item
    private function implodeCommaCommaAmpersand(array $array) {
        return join(' & ', array_filter(array_merge(array(join(', ', array_slice($array, 0, -1))), array_slice($array, -1)), 'strlen'));
    }
}
