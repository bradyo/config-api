<?php
namespace Api\Account;

class ListAccountsHandler
{
    private $accountRepo;

    public function __construct(AccountRepo $accountRepo) {
        $this->accountRepo = $accountRepo;
    }

    public function handle(ListAccountsRequest $request)
    {
        $query = $request->getQuery();
        $accounts = $this->accountRepo->find($query);
        $total = $this->accountRepo->count($query);

        return new AccountListResponse($accounts, $total, $request);
    }
}