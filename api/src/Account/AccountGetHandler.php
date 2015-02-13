<?php
namespace Api\Account;

class AccountGetHandler
{
    private $router;

    public function __construct($accountId)
    {
        $this->accountId = $accountId;
    }

    public function handle(AuthenticatedRequest $request)
    {
        if (! $request->matchesAccountId($this->accountId)) {
            return new NotAllowedResponse("Not allowed to access account");
        }

        $matchedRoute = $this->router->match($request);
        if ($matchedRoute === null) {
            return new NotFoundResponse("Account route not found");
        }

        $handler = $matchedRoute->getHandler();

        return $handler->handle($request);
    }
}