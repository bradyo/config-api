<?php
namespace Api\Account;

use Api\Web\ClientRequest;

class ListAccountsRequest extends ClientRequest
{
    private $request;

    public function __construct(ClientRequest $request)
    {
        parent::__construct($request, $request->getClient());
        $this->request = $request;
    }

    public function getQuery()
    {
        $data = $this->getData();

        return new AccountsQuery(
            $this->request->getClient()->getId(),
            $data['search'],
            $data['limit'],
            $data['offset']
        );
    }
}