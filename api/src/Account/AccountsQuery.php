<?php
namespace Api\Account;

class AccountsQuery
{
    const MAX_LIMIT = 100;

    private $clientId;
    private $search;
    private $limit;
    private $offset;

    function __construct($clientId, $search, $limit, $offset)
    {
        $this->clientId = $clientId;
        $this->search = $search;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function getLimit()
    {
        return min($this->limit, self::MAX_LIMIT);
    }

    public function getOffset()
    {
        return max($this->offset, 0);
    }
}