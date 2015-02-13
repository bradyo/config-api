<?php
namespace Api\Web;

use Commando\Web\Request;

class NotAuthenticatedResponse extends ErrorResponse
{
    public function __construct($message, Request $request)
    {
        parent::__construct($message, $request, 401);
    }
}