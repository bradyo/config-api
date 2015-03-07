<?php
namespace Api\Web;

use Api\ApplicationResponse;
use Commando\Web\Request;

class ErrorResponse extends ApplicationResponse
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