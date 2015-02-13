<?php
namespace Api;

use Api\Account\AccountsHandler;
use Api\Client\Client;
use Api\Web\BadRequestResponse;
use Api\Web\ClientRequest;
use Api\Web\NotAllowedResponse;
use Api\Web\NotAuthenticatedResponse;
use Api\Security\Guard;
use Api\Web\NotFoundResponse;
use Api\Web\RateLimitedResponse;
use Api\Web\Route;
use Commando\Web\MatchedRoute;
use Commando\Web\Method;
use Commando\Web\Request;
use Commando\Web\RequestHandler;
use Commando\Web\Router;
use Pimple\Container;
use PDO;

class Application extends \Commando\Application implements RequestHandler
{
    private $container;
    private $router;

    public function __construct(array $config)
    {
        parent::__construct();
        $this->setWebRequestHandler($this);

        header_remove("X-Powered-By");

        $container = new Container();
        $container['database'] = function () {
            return new PDO('sqlite:' . dirname(__DIR__) . '/data/database.sqlite', null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        };
        $container['get-home-handler'] = function () {
            return new GetHomeHandler();
        };
        $container['accounts-handler'] = function () {
            return new AccountsHandler();
        };
        $container['guard'] = function () {
            return new Guard();
        };
        $this->container = $container;

        $this->router = new Router([
            new Route(Method::GET, '/',         'get-home-handler'),
            new Route(Method::ANY, '/accounts', 'accounts-handler'),
        ]);
    }

    public function handle(Request $request)
    {
        /** @var Client $client */
        $client = $this->container['guard']->authenticate($request);

        if ($client === null) {
            $response = new NotAuthenticatedResponse("Must authenticate with HTTP Basic Auth", $request);
        } else {
            $clientRequest = new ClientRequest($request, $client);
            if ($clientRequest->isOverRateLimit()) {
                return new RateLimitedResponse("Request rate limit exceeded", $clientRequest);
            }
            if (! $clientRequest->hasValidAuthToken()) {
                return new NotAllowedResponse("Two-factor auth token is invalid", $clientRequest);
            }
            if ($clientRequest->hasParseError()) {
                return new BadRequestResponse('Request body could not be parsed', $clientRequest);
            }

            /** @var MatchedRoute $matchedRoute */
            $matchedRoute = $this->router->match($clientRequest);
            if ($matchedRoute === null) {
                return new NotFoundResponse('Route not found', $clientRequest);
            }

            /** @var ClientRequestHandler $handler */
            $handler = $this->container[$matchedRoute->getValue()];
            $response = $handler->handle($clientRequest);
        }

        return new ApplicationResponse($response);
    }

}