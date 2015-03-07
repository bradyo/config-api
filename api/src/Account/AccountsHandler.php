<?php
namespace Api\Account;

use Api\Web\ClientRequest;

class AccountsHandler
{
    public function __construct($handlers)
    {
        $this->handlers = $handlers;
    }

    public function handle(ClientRequest $request)
    {
        $router = new AccountsRouter($this->handlers);

        return $router->handle($request);
    }
}