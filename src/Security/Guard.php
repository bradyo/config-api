<?php
namespace Api\Security;

use Commando\Web\Request;
use Api\Client\Client;
use Api\Account\Account;

class Guard
{
    /**
     * Authenticate an HTTP request using HTTP basic auth.
     *
     * @param Request $request
     * @return Client The authenticated client making the request
     */
    public function authenticate(Request $request)
    {
        // todo: check authorization header and return calling Client
        if ($request->getHeader('Authorization') === null) {
            return null;
        }

        return new Client("1234", "ConsumerApp", new Account("12345"));
    }
}