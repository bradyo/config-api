<?php
namespace Api\Web;

class BadRequestResponse extends ClientResponse
{
    public function __construct($message, ClientRequest $request)
    {
        $data = [
            'status' => 'error',
            'message' => $message,
            'parseError' => $request->getParseError()
        ];
        parent::__construct($data, $request, 400);
    }
}