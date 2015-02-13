<?php
namespace Api\Web;

use Api\Client\Client;
use Commando\Web\Request;

class ClientRequest extends DataRequest
{
    private $client;

    public function __construct(Request $request, Client $client)
    {
        parent::__construct($request);
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function matchesAccountId($otherAccountId)
    {
        return $this->client->matchesAccountId($otherAccountId);
    }

    public function getApiCallsLimit()
    {
        return 1000;
    }

    public function getApiCallsRemaining()
    {
        return $this->client->getApiCallsRemaining();
    }

    public function isOverRateLimit()
    {
        return $this->client->isOverRateLimit();
    }

    public function hasValidAuthToken()
    {
        return true;
        return $this->getClient()->isValidAuthToken($this->getHeader('AuthToken'));
    }
}