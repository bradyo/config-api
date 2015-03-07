<?php
namespace Api\Account;

class NewAccount
{
    private $name;
    private $contactEmailAddress;

    public function __construct($name, $contactEmailAddress)
    {
        $this->name = $name;
        $this->contactEmailAddress = $contactEmailAddress;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContactEmailAddress()
    {
        return $this->contactEmailAddress;
    }
}