<?php
namespace Api;

use Commando\Web\Request;
use Commando\Web\Router;

class RouteMatcher
{
    private $match;

    function __construct(array $routes, Request $request)
    {
        $router = new Router($routes);
        $this->match = $router->match($request);
    }

    public function getMatch()
    {
        return $this->match->getValue();
    }

    public function getParam($name)
    {
        return $this->match->getParam($name);
    }
}