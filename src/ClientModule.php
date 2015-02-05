<?php
namespace Api;

use Api\Account\AccountHandler;
use Api\Web\ClientRequest;
use Api\Web\BadRequestResponse;
use Api\Web\NotAllowedResponse;
use Api\Web\NotFoundResponse;
use Api\Web\RateLimitedResponse;
use Api\Web\Route;
use Commando\Web\MatchedRoute;
use Commando\Web\Method;
use Commando\Web\Router;
use Pimple\Container;

class ClientModule implements ClientRequestHandler
{
    private $container;

    public function __construct()
    {
        $container = new Container();
        $container['get-home-handler'] = function () {
            return new GetHomeHandler();
        };
        $container['account-handler'] = function () {
            return new AccountHandler();
        };
        $container['router'] = function () {
            return new Router([
                new Route(Method::GET, '/',         'get-home-handler'),
                new Route(Method::ANY, '/accounts', 'account-module'),
            ]);
        };
        $this->container = $container;
    }

    public function handle(ClientRequest $request)
    {
        if ($request->isOverRateLimit()) {
            return new RateLimitedResponse("Request rate limit exceeded", $request);
        }
        if (! $request->hasValidUserAgent()) {
            return new NotAllowedResponse('User agent is invalid', $request);
        }
        if (! $request->hasValidAuthToken()) {
            return new NotAllowedResponse("Two-factor auth token is invalid", $request);
        }
        if ($request->hasParseError()) {
            return new BadRequestResponse('Request body could not be parsed', $request);
        }

        /** @var MatchedRoute $matchedRoute */
        $matchedRoute = $this->container['router']->match($request);
        if ($matchedRoute === null) {
            return new NotFoundResponse('Route not found', $request);
        }

        /** @var ClientRequestHandler $handler */
        $handler = $this->container[$matchedRoute->getValue()];
        $response = $handler->handle($request);

        return $response;
    }
}