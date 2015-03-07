<?php
namespace Api;

use Api\Web\ClientRequest;
use Api\Web\NotFoundResponse;
use Api\Web\Route;
use Commando\Web\Method;
use Pimple\Container;

class ApplicationRouter
{
    private $handlers;
    private $routes;

    public function __construct(Container $handlers)
    {
        $this->handlers = $handlers;
        $this->routes = [
            new Route(Method::GET, '/',         'get-home'),
            new Route(Method::ANY, '/accounts', 'accounts'),
        ];
    }

    public function handle(ClientRequest $request)
    {
        $matcher = new RouteMatcher($this->routes, $request);
        $match = $matcher->getMatch();
        switch ($match) {
            case 'get-home':
            case 'accounts':
                return $this->handlers[$match]->handle($request);

            default:
                return new NotFoundResponse('Route not found', $request);
        }
    }
}