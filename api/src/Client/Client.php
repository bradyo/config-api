<?php
namespace Api\Client;

use Api\Account\Account;

class Client
{
    private $id;
    private $name;
    private $account;

    public function __construct($id, $name, Account $account)
    {
        $this->id = $id;
        $this->name = $name;
        $this->account = $account;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function matchesAccountId($otherAccountId)
    {
        return $this->getAccount()->getId() === $otherAccountId;
    }

    public function getApiCallsRemaining()
    {
        return 5000;
    }

    public function isOverRateLimit()
    {
        return $this->getApiCallsRemaining() < 1;
    }

    public function requiresAuthToken()
    {
        return true;
    }

    public function getAuthToken()
    {
        return '123456';
    }

    public function isValidAuthToken($value)
    {
        return $this->requiresAuthToken() && $this->getAuthToken() == $value;
    }
}