<?php

namespace Quezler\OnePasswordPhpApi;

use Illuminate\Support\Collection;
use LogicException;
use Quezler\OnePasswordPhpApi\Object\Account;
use Quezler\OnePasswordPhpApi\Object\Item;
use Quezler\OnePasswordPhpApi\Object\Vault;

class OP
{
    public static function getExecutablePath() {
        return Package::getBasePath() . '/executable/op';
    }

    public function getCredentials(): array {
        return [
            'your-account-name' =>    getenv('1PASSWORD_ACCOUNT_NAME'),
            'your-account-address' => getenv('1PASSWORD_ACCOUNT_EMAIL'),
            'your-secret-key' =>      getenv('1PASSWORD_ACCOUNT_SECRET'),
            'your-master-password' => getenv('1PASSWORD_ACCOUNT_MASTER'),
        ];
    }

    private $session;

    /**
     * @return string|null
     */
    public function getSession()
    {
        return $this->session;
    }

    private function fetchSession() {

        if (empty(array_filter($this->getCredentials()))) {
            throw new LogicException('401: Authentication required.');
        };

        exec(OP::getExecutablePath() .' signin --output=raw '. implode(' ', $this->getCredentials()), $output);

        if (!isset($output[0])) {
            throw new LogicException('401: Authentication required.');
        }

        return $output[0];
    }

    function __construct()
    {
        $this->session = $this->fetchSession();
    }

    public function getExport(): string {
        return 'export OP_SESSION_my="'. $this->session .'"';
    }

    public function getCommandPrefix(): string {
         return $this->getExport() .' && '. OP::getExecutablePath() .' '; // export OP_SESSION_my="foobar" && /path/to/package/src/../executable/op
    }

    public function command(string $command) {
        dump("OP: $command"); // fixme: remove
        $cmd = $this->getCommandPrefix() . $command;

        exec($cmd, $output);

        return \GuzzleHttp\json_decode($output[0]);
    }

    /**
     * @return Collection|Vault[]
     */
    public function getVaults(): Collection {

        $array = $this->command('list vaults');

        return (new Collection($array))->map(function ($object) { return new Vault($this, $object->uuid); });
    }

    private $account;

    public function getAccount(): Account {
        return $this->account ?: $this->account = new Account(
            $this, $this->command('get account')
        );
    }

    public function getItems(Vault $vault = null): Collection {

        $command = 'list items';

        if ($vault) {
            $command = "$command --vault={$vault->getUuid()}";
        }

        $items = $this->command($command);

        return (new Collection($items))->map(function ($object) { return new Item($this, $object); });
    }
}
