<?php

namespace Quezler\OnePasswordPhpApi;

use LogicException;

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

    function __construct()
    {
        $this->session = $this->fetchSession();
    }

    private function fetchSession() {
        exec(OP::getExecutablePath() .' signin --output=raw '. implode(' ', $this->getCredentials()), $output);

        if (!isset($output[0])) {
            throw new LogicException('401: Authentication required.');
        }

        return $output[0];
    }
}
