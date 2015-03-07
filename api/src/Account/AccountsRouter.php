<?php
namespace Api\Account;

use Api\RouteMatcher;
use Api\Web\ClientRequest;
use Api\Web\NotFoundResponse;
use Api\Web\Route;
use Commando\Web\Method;
use Pimple\Container;

class AccountsRouter
{
    private $handlers;
    private $routes;

    public function __construct(Container $handlers)
    {
        $this->handlers = $handlers;
        $this->routes = [
            new Route(Method::GET,  '/',                'list'),
            new Route(Method::POST, '/',                'post'),
            new Route(Method::GET,  '/:hash',           'get'),
            new Route(Method::ANY,  '/:hash/configs',   'configs'),
            new Route(Method::ANY,  '/:hash/consumers', 'consumers')
        ];
    }

    public function handle(ClientRequest $request)
    {
        $matcher = new RouteMatcher($this->routes, $request);
        $match = $matcher->getMatch();
        switch ($match) {
            case 'list':
                return $this->handlers[$match]->handle(new ListAccountsRequest($request));

            case 'post':
                return $this->handlers[$match]->handle(new PostAccountRequest($request));

            case 'get':
            case 'configs':
            case 'consumers':
                $accountHash = $matcher->getParam('hash');
                return $this->handlers[$match]->handle(new AccountRequest($request, $accountHash));

            default:
                return new NotFoundResponse('Route not found', $request);
        }
    }
}