<?php
namespace Api\Account;

use Api\Web\ClientRequest;
use Api\Web\DataResponse;

class AccountResponse extends DataResponse
{
    private $account;
    private $request;

    function __construct(Account $account, ClientRequest $request, $statusCode = 200)
    {
        parent::__construct(null, $request, $statusCode);
        $this->account = $account;
        $this->request = $request;
    }

    public function getHref()
    {
        return $this->request->getUrlBase() . '/accounts/' . $this->account->getId();
    }

    public function getData()
    {
        return [
            'href' => $this->getHref(),
            'id' => $this->account->getId(),
        ];
    }
}