<?php
namespace Api\Web;

use Commando\Web\Request;

class ErrorResponse extends DataResponse
{
    /**
     * @param string $message
     * @param Request $request
     * @param int $statusCode
     */
    public function __construct($message, Request $request, $statusCode = 500)
    {
        $data = [
            'status' => 'error',
            'message' => $message,
        ];
        parent::__construct($data, $request, $statusCode);
    }
}