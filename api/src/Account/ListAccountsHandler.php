<?php
namespace Api\Account;

use Api\Web\ValidationErrorResponse;

class ListAccountsHandler
{
    private $requestValidator;
    private $accountRepository;

    public function __construct(
        AccountListRequestValidator $requestValidator,
        AccountRepository $accountRepository
    ) {
        $this->requestValidator = $requestValidator;
        $this->accountRepository = $accountRepository;
    }

    public function handle(AccountsListRequest $request)
    {
        $errors = $this->requestValidator->validate($request);
        if (count($errors) > 0) {
            return new ValidationErrorResponse('Invalid request', $errors, $request);
        }

        $accounts = $this->accountRepository->findAll(
            $request->getAccountId(),
            $request->getSearch(),
            $request->getFilter(),
            $request->getLimit(),
            $request->getOffest()
        );

        return new AccountsListResponse($accounts, $request);
    }
}