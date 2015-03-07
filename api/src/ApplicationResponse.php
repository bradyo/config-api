<?php
namespace Api;

use Api\Web\DataResponse;
use Commando\Web\Request;
use Commando\Web\ResponseDecorator;

class ApplicationResponse extends DataResponse
{
    function __construct($data, Request $request, $statusCode = 200, $headers = [])
    {
        parent::__construct($data, $request, $statusCode, $headers);
    }

    public function getHeaders()
    {
        return array_merge(
            parent::getHeaders(),
            [
                'Server' => 'Config-API/1.0.0',
                'RequestId' => md5(uniqid('', true))
            ]
        );
    }
}