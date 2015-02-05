<?php
namespace Api;

use Api\Client\Client;
use Api\Web\ClientRequest;
use Api\Web\NotAuthenticatedResponse;
use Api\Security\Guard;
use Commando\Web\Request;
use Commando\Web\RequestHandler;
use Pimple\Container;
use PDO;

class Application extends \Commando\Application implements RequestHandler
{
    private $container;

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
        $container['guard'] = function () {
            return new Guard();
        };
        $container['client-module'] = function () {
            return new ClientModule();
        };
        $this->container = $container;
    }

    public function handle(Request $request)
    {
        /** @var Client $client */
        $client = $this->container['guard']->authenticate($request);

        if ($client === null) {
            $response = new NotAuthenticatedResponse("Must authenticate with HTTP Basic Auth", $request);
        } else {
            /** @var ClientRequestHandler $handler */
            $handler = $this->container['client-module'];
            $clientRequest = new ClientRequest($request, $client);
            $response = $handler->handle($clientRequest);
        }

        return new ApplicationResponse($response);
    }

}