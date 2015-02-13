<?php
namespace Api\Web;

class NotFoundResponse extends ClientErrorResponse
{
    public function __construct($message, ClientRequest $request)
    {
        parent::__construct($message, $request, 404);
    }
}