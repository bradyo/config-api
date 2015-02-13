<?php
namespace Api\Account;

use Api\Web\ClientRequest;

class ListAccountsRequest extends AccountRequest
{
    use ListRequest;

    public function __construct(ClientRequest $request, $accountId)
    {
        parent::__construct($request, $accountId);
    }
}