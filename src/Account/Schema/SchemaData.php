<?php
namespace Api\Schema;

class SchemaData
{
    private $accountId;
    private $name;
    private $data;

    function __construct($accountId, $name, array $data)
    {
        $this->accountId = $accountId;
        $this->name = $name;
        $this->data = $data;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getData()
    {
        return $this->data;
    }
}