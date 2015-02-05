<?php
namespace Api\Web;

class RateLimitedResponse extends ClientErrorResponse
{
    function __construct($message, ClientRequest $request)
    {
        parent::__construct($message, $request, 429);
    }

    public function getHeaders()
    {
        return array_merge(
            parent::getHeaders(),
            [
                'Retry-After' => 60
            ]
        );
    }
}