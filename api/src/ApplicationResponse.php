<?php
namespace Api;

use Commando\Web\Response;
use Commando\Web\ResponseDecorator;

class ApplicationResponse implements Response
{
    use ResponseDecorator;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getHeaders()
    {
        return array_merge(
            $this->response->getHeaders(),
            [
                'Server' => 'Config-API/1.0.0',
                'RequestId' => md5(uniqid('', true))
            ]
        );
    }
}