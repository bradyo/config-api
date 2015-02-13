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
    private $container;
    private $router;

    public function __construct()
    {
        $container = new Container();
        $container['get-account-handler'] = function () {
            return new GetAccountHandler();
        };
        $container['schemas-handler'] = function () {
            return new SchemasHandler();
        };
        $container['configs-handler'] = function () {
            return new ConfigsHandler();
        };
        $this->container = $container;

        $this->router = new Router([
            new Route(Method::GET, '/',    'list-accounts-handler'),
            new Route(Method::ANY, '/:id', 'account-handler'),
        ]);
    }

    public function handle(ClientRequest $request)
    {
        $matchedRoute = $this->router->match($request);

        if (! $request->matchesAccountId($request->getAccountId())) {
            return new NotAllowedResponse("Not allowed to access account", $request);
        }

        if ($matchedRoute === null) {
            return new NotFoundResponse("Account route not found", $request);
        }

        $handler = $matchedRoute->getHandler();

        $response = $handler->handle($request);

        return $response;
    }
}