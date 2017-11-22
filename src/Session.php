<?php

namespace Quezler\OnePasswordPhpApi;

use LogicException;

class Session
{
    /**
     * @var OP
     */
    private $op;

    /**
     * @var string
     */
    private $session;

    function __construct(OP $op)
    {
        $this->op = $op;
        $this->session = $this->fetchSession();
    }

    private function getCredentials(): array {
        return [
            'your-account-name' =>    getenv('1PASSWORD_ACCOUNT_NAME'),
            'your-account-address' => getenv('1PASSWORD_ACCOUNT_EMAIL'),
            'your-secret-key' =>      getenv('1PASSWORD_ACCOUNT_SECRET'),
            'your-master-password' => getenv('1PASSWORD_ACCOUNT_MASTER'),
        ];
    }

    private function fetchSession() {

        if (empty(array_filter($this->getCredentials()))) {
            throw new LogicException('401: Authentication required.');
        };

        exec($this->op->getExecutable()->getPath() .' signin --output=raw '. implode(' ', $this->getCredentials()), $output);

        if (!isset($output[0])) {
            throw new LogicException('401: Authentication required.');
        }

        return $output[0];
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @return string
     */
    public function getExport(): string
    {
        return "export OP_SESSION_my=\"{$this->getSession()}\"";
    }
}
