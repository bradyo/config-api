<?php
namespace Api\Schema;

class Schema extends SchemaData
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';

    private $id;
    private $status;
    private $createdAt;

    function __construct($id, $accountId, $name, $status, $createdAt, array $data)
    {
        parent::__construct($accountId, $name, $data);

        $this->id = $id;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}