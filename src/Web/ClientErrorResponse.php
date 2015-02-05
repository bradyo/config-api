<?php
namespace Api\Web;

class ClientErrorResponse extends ClientResponse
{
    /**
     * @param string $message
     * @param ClientRequest $request
     * @param int $statusCode
     */
    public function __construct($message, ClientRequest $request, $statusCode = 500)
    {
        $data = [
            'status' => 'error',
            'message' => $message,
        ];
        parent::__construct($data, $request, $statusCode);
    }
}