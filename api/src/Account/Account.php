<?php
namespace Api\Account;

class Account
{
    private $id;
    private $hash;
    private $name;
    private $contactEmailAddress;

    public function __construct($id, $hash, $name, $contactEmailAddress)
    {
        $this->id = $id;
        $this->hash = $hash;
        $this->name = $name;
        $this->contactEmailAddress = $contactEmailAddress;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHash()
    {
        return $this->hash;
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