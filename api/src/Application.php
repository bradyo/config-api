<?php
namespace Api;

use Api\Account\AccountModule;
use Api\Account\Config\ConfigModule;
use Api\Account\Consumer\ConsumerModule;
use Api\Security\Guard;
use Commando\Web\Request;
use Commando\Web\RequestHandler;
use Pimple\Container;
use PDO;

class Application extends \Commando\Application implements RequestHandler
{
    private $services;
    private $handlers;

    public function __construct(array $config)
    {
        parent::__construct();

        $this->setWebRequestHandler($this);
        header_remove("X-Powered-By");

        $this->services = new Container([
            'database' => function () {
                $dsn = 'sqlite:' . dirname(__DIR__) . '/data/database.sqlite';
                $username = null;
                $password = null;
                return new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            },
            'guard' => function () {
                return new Guard();
            },
            'config-module' => function () {
                return new ConfigModule($this->services['database']);
            },
            'consumer-module' => function () {
                return new ConsumerModule($this->services['database']);
            },
            'account-module' => function () {
                return new AccountModule(
                    $this->services['database'],
                    $this->services['config-module'],
                    $this->services['consumer-module']
                );
            },
        ]);

        $this->subHandlers = new Container([
            'get-home' => function () {
                return new GetHomeHandler();
            },
            'accounts' => function () {
                return $this->services['account-module'];
            }
        ]);
    }

    public function handle(Request $request)
    {
        $handler = new ApplicationHandler($this->services['guard'], $this->subHandlers);

        return $handler->handle($request);
    }
}