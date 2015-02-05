<?php


namespace Api\Account;


use Pimple\Container;

class AccountModule
{
    public function __construct()
    {
        $container = new Container();
        $container['router'] = function () {

        };
    }

    public function getRequestHandler()
    {
        return $this->container['handler'];
    }
}