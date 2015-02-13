<?php
namespace Api\Web;

class ClientResponse extends DataResponse
{
    private $request;

    function __construct($data, ClientRequest $request, $statusCode = 200, $headers = [])
    {
        parent::__construct($data, $request, $statusCode, $headers);
        $this->request = $request;
    }

    public function getHeaders()
    {
        return array_merge(
            parent::getHeaders(),
            [
                'RateLimit-Limit' => $this->request->getApiCallsLimit(),
                'RateLimit-Remaining' => $this->request->getApiCallsRemaining()
            ]
        );
    }
}