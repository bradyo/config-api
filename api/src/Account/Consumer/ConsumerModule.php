<?php
namespace Api\Account\Consumer;

use Api\Web\ClientRequest;
use Api\Web\NotFoundResponse;
use Pimple\Container;
use PDO;

class ConsumerModule
{
    private $services;
    private $handlers;

    public function __construct(PDO $pdo)
    {
        $this->services = new Container([
        ]);

        $this->handlers = new Container([
        ]);
    }

    public function handle(ClientRequest $request)
    {
        return new NotFoundResponse('Nothing to see here, move along...', $request);
    }
}