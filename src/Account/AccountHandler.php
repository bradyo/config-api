<?php
namespace Api\Account;

use Api\Web\ClientRequest;
use Api\Web\NotAllowedResponse;
use Api\Web\NotFoundResponse;
use Api\Web\Route;
use Commando\Web\Method;
use Commando\Web\Router;
use Pimple\Container;

class AccountHandler
{
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
        $request->getUri();


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