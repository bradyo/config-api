<?php
namespace Api\Account;

use Api\Web\ClientRequest;

class AccountRequest extends ClientRequest
{
    private $accountHash;

    /**
     * @param ClientRequest $request
     * @param string $accountHash
     */
    public function __construct(ClientRequest $request, $accountHash)
    {
        parent::__construct($request, $request->getClient());
        $this->accountHash = $accountHash;
    }

    public function getAccountHash()
    {
        return $this->accountHash;
    }

    public function getUri()
    {
        return substr(parent::getUri(), strlen('/accounts/' . $this->accountHash));
    }
}