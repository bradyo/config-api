<?php
namespace Api\Account;

use Api\Web\ClientRequest;
use Api\Web\NotAllowedResponse;
use Api\Web\NotFoundResponse;
use Api\Web\Route;
use Commando\Web\Method;
use Commando\Web\Router;
use Pimple\Container;

class AccountsHandler
{
    private $router;

    public function __construct()
    {
        $container = new Container();
        $container['list-accounts-handler'] = function () {
            return new ListAccountsHandler();
        };
        $container['account-handler'] = function () {
            return new AccountHandler();
        };
        $container['router'] = function () {
            return new Router([
                new Route(Method::GET, '/',    'list-accounts-handler'),
                new Route(Method::ANY, '/:id', 'account-handler'),
            ]);
        };
        $this->container = $container;
    }

    public function handle(ClientRequest $request)
    {
        if (preg_match('/^\/accounts$', $request->getUri())) {
            $subRequest = new ListAccountsRequest($request);
            $this->container['list-account-handler']->handle($subRequest);
        }
        elseif (preg_match('/^\/accounts\/(\d+)$', $request->getUri())) {

        }


        if (! $request->matchesAccountId($this->accountId)) {
            return new NotAllowedResponse("Not allowed to access account", $request);
        }

        $matchedRoute = $this->router->match($request);
        if ($matchedRoute === null) {
            return new NotFoundResponse("Account route not found", $request);
        }

        $handler = $matchedRoute->getHandler();

        $response = $handler->handle($request);

        return $response;
    }
}