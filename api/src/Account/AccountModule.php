<?php
namespace Api\Account;

use Api\Account\Config\ConfigModule;
use Api\Account\Consumer\ConsumerModule;
use Api\Web\ClientRequest;
use Pimple\Container;
use PDO;

class AccountModule
{
    private $pdo;
    private $configModule;
    private $consumerModule;
    private $services;
    private $handlers;

    public function __construct(PDO $pdo, ConfigModule $configModule, ConsumerModule $consumerModule)
    {
        $this->pdo = $pdo;
        $this->configModule = $configModule;
        $this->consumerModule = $consumerModule;

        $this->services = new Container([
            'account-repository' => function () {
                new AccountRepo($this->pdo);
            },
            'new-account-validator' => function () {
                new NewAccountValidator();
            }
        ]);

        $this->handlers = new Container([
            'list' => function () {
                return new ListAccountsHandler(
                    $this->services['account-repository']
                );
            },
            'post' => function () {
                return new PostAccountHandler(
                    $this->services['account-repository'],
                    $this->services['new-account-validator']
                );
            },
            'get' => function () {
                return new GetAccountHandler(
                    $this->services['account-repository']
                );
            },
            'configs' => function () {
                return $this->configModule;
            },
            'consumers' => function () {
                return $this->configModule;
            }
        ]);
    }

    public function handle(ClientRequest $request)
    {
        $router = new AccountsRouter($this->handlers);

        return $router->handle($request);
    }
}