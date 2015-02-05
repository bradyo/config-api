<?php
namespace Api;

use Api\Web\ClientRequest;
use Commando\Web\Response;

interface ClientRequestHandler
{
    /**
     * @param ClientRequest $request
     * @return Response
     */
    public function handle(ClientRequest $request);
}