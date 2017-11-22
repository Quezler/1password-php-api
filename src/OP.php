<?php

namespace Quezler\OnePasswordPhpApi;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Quezler\OnePasswordPhpApi\Object\Account;
use Quezler\OnePasswordPhpApi\Object\Avatar;
use Quezler\OnePasswordPhpApi\Object\Item;
use Quezler\OnePasswordPhpApi\Object\Template;
use Quezler\OnePasswordPhpApi\Object\Vault;
use stdClass;

class OP
{
    /**
     * @var Executable
     */
    private $executable;

    /**
     * @var Session
     */
    private $session;

    /**
     * @return Executable
     */
    public function getExecutable(): Executable
    {
        return $this->executable;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    function __construct()
    {
        $this->executable = new Executable($this);
        $this->session = new Session($this);
    }

    public function getVault(string $query) {
        $object = $this->executable->command('get vault', [$query]);
        $object = $this->cast($object);
        $vault = new Vault($this, $object->uuid);
        $vault->setDetails($object);
        return $vault;
    }

    /**
     * @return Collection|Vault[]
     */
    public function getVaults(): Collection {

        $array = $this->executable->command('list vaults', []);

        return (new Collection($array))->map(function ($object) { return new Vault($this, $object->uuid); });
    }

    private $account;

    public function getAccount(): Account {
        return $this->account ?: $this->account = new Account(
            $this, $this->executable->command('get account', [])
        );
    }

    public function getItems(Vault $vault = null): Collection {

        $command = 'list items';
        $arguments = [];

        if ($vault) {
            $arguments['--vault'] = $vault->getUuid();
        }

        $items = $this->executable->command('list items', $arguments);

        return (new Collection($items))->map(function ($object) { return new Item($this, $object); });
    }

    public function getTemplates(): Collection {
        return (new Collection(
            $this->executable->command('list templates', [])
        ))->map(function (stdClass $object) { return new Template($this, $object); });

    }

    public function cast(stdClass $object) {

        if (isset($object->avatar)) {
            $object->avatar = new Avatar($this, $object->avatar);
        }

        if (isset($object->createdAt)) {
            $object->createdAt = new Carbon($object->createdAt);
        }

        return $object;
    }


}
