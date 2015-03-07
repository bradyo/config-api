<?php
namespace Api\Account;

use Api\Web\NotAllowedResponse;

class GetAccountHandler
{
    private $accountRepo;

    public function __construct(AccountRepo $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    public function handle(AccountRequest $request)
    {
        $accountId = $request->getAccountHash();
        if (! $request->getClient()->canAccessAccount($accountId)) {
            return new NotAllowedResponse("Not allowed to access account", $request);
        }

        $account = $this->accountRepo->get($accountId);

        return new AccountResponse($account, $request);
    }
}