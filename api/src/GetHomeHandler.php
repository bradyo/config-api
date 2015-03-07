<?php
namespace Api;

use Api\Web\ClientResponse;
use Commando\Web\CacheControlResponse;
use Commando\Web\Request;

class GetHomeHandler
{
    public function handle(Request $request)
    {
        $data = [
            'name' => 'Config API',
            'description' => 'Application config management and validation API.',
            'version' => '1.0.0',
            'website_url' => 'http://localhost:8080',
            'developer_url' => 'http://localhost:8081',
        ];
        $response = new ApplicationResponse($data, $request);

        return new CacheControlResponse($response, $request, 600);
    }
}