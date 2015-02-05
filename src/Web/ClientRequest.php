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

    public function getApiCallsRemaining()
    {
        return $this->client->getApiCallsRemaining();
    }

    public function hasValidUserAgent()
    {
        return $this->getHeader('User-Agent') == $this->getClient()->getName();
    }

    public function isOverRateLimit()
    {
        return $this->client->isOverRateLimit();
    }

    public function hasValidAuthToken()
    {
        return $this->getClient()->isValidAuthToken($this->getHeader('AuthToken'));
    }
}