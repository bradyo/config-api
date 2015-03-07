<?php
namespace Api\Account;

use Api\Web\ClientRequest;
use Api\Web\DataResponse;

class AccountListResponse extends DataResponse
{
    private $accounts;
    private $total;
    private $request;

    /**
     * @param Account[] $accounts
     * @param integer $total
     * @param ClientRequest $request
     */
    function __construct(array $accounts, $total, ClientRequest $request)
    {
        parent::__construct(null, $request, 200);
        $this->accounts = $accounts;
        $this->total = $total;
        $this->request = $request;
    }

    public function getData()
    {
        $itemsData = [];
        foreach ($this->accounts as $account) {
            $accountResponse = new AccountResponse($account, $request);
            $itemsData[] = $accountResponse->getData();
        }

        return [
            'total' => $this->total,
            'items' => $itemsData
        ];
    }
}