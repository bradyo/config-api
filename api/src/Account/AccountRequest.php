<?php
namespace Api\Account;

use Api\Web\ClientRequest;

class AccountRequest extends ClientRequest
{
    private $accountId;

    public function __construct(ClientRequest $request, $accountId)
    {
        parent::__construct($request, $request->getClient());
        $this->accountId = $accountId;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }
}