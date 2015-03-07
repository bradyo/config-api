<?php
namespace Api\Web;

use Api\Client\Client;
use Commando\Web\Request;

class ClientRequest extends DataRequest
{
    private $client;
    private $requiresAuthToken = false;

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
        return $this->client->canAccessAccount($otherAccountId);
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

    public function hasInvalidAuthToken()
    {
        if ($this->requiresAuthToken) {
            return $this->getClient()->isValidAuthToken($this->getHeader('AuthToken'));
        } else {
            return false;
        }
    }

    public function getUrlBase()
    {
        return $this->getScheme() . $this->getServerName();
    }
}