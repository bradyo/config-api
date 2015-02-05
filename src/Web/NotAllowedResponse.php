<?php
namespace Api\Web;

class NotAllowedResponse extends ClientErrorResponse
{
    public function __construct($message, ClientRequest $request)
    {
        parent::__construct($message, $request, 403);
    }
}