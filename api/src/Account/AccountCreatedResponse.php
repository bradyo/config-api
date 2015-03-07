<?php
namespace Api\Account;

use Api\Web\ClientRequest;

class AccountCreatedResponse extends AccountResponse
{
    private $account;
    private $request;

    function __construct(Account $account, ClientRequest $request)
    {
        parent::__construct(null, $request, 201);
        $this->account = $account;
        $this->request = $request;
    }

    public function getHeaders()
    {
        return array_merge(
            parent::getHeaders(),
            ['Location' => $this->getHref()]
        );
    }


}