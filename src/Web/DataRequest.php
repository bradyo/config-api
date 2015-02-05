<?php
namespace Api\Web;

use Commando\Web\Request;
use Commando\Web\RequestDecorator;

class DataRequest implements Request
{
    use RequestDecorator;

    private $data;
    private $parseError;

    function __construct(Request $request)
    {
        $this->request = $request;
        if (! in_array($request->getRequestMethod(), ['POST', 'PUT', 'PATCH'])) {
            return null;
        }
        switch ($request->getHeader('Content-type')) {
            case 'application/x-www-form-urlencoded':
                $this->data = urldecode($request->getBody());
                break;

            default:
                $this->data = json_decode($request->getBody());
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->parseError = "Failed to decode JSON string";
                }
                break;
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function hasParseError()
    {
        return isset($this->parseError);
    }

    public function getParseError()
    {
        return $this->parseError;
    }

    public function getSupportedAcceptHeaders()
    {
        return [
            'application/json',
            'application/x-www-form-urlencoded',
        ];
    }
}