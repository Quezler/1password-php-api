<?php

namespace Quezler\OnePasswordPhpApi;

use Illuminate\Support\Collection;
use LogicException;
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

    private function fetchSession() {
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

    public function runOpCommand(string $command) {
        $cmd = $this->getCommandPrefix() . $command;

        exec($cmd, $output);

        return \GuzzleHttp\json_decode($output[0]);
    }

    /**
     * @return Collection|Vault[]
     */
    public function getVaults(): Collection {

        $array = $this->runOpCommand('list vaults');

        return (new Collection($array))->map(function ($object) { return new Vault($object->uuid); });
    }
}
