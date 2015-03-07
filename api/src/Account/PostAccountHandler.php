<?php
namespace Api\Account;

use Api\Web\ValidationErrorResponse;

class PostAccountHandler
{
    private $accountRepo;
    private $postValidator;

    public function __construct(AccountRepo $accountRepo, NewAccountValidator $postValidator)
    {
        $this->accountRepo = $accountRepo;
        $this->postValidator = $postValidator;
    }

    public function handle(PostAccountRequest $request)
    {
        $newAccount = $request->getNewAccount();
        $errors = $this->postValidator->validate($newAccount);
        if (count($errors) > 0) {
            return new ValidationErrorResponse('Account post is invalid', $errors, $request);
        }

        $account = $this->accountRepo->save($newAccount);

        return new AccountCreatedResponse($account, $request);
    }
}