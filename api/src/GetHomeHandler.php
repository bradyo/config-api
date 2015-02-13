<?php
namespace Api;

use Api\Web\ClientRequest;
use Api\Web\ClientResponse;
use Commando\Web\CacheControlResponse;

class GetHomeHandler implements ClientRequestHandler
{
    public function handle(ClientRequest $request)
    {
        $data = [
            'name' => 'Config API',
            'description' => 'Application config management and validation API.',
            'version' => '1.0.0',
        ];
        $response = new ClientResponse($data, $request);

        return new CacheControlResponse($response, $request, 600);
    }
}