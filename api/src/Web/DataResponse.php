<?php
namespace Api\Web;

use Commando\Web\Request;
use Commando\Web\TextResponse;

class DataResponse extends TextResponse
{
    private $data;
    private $request;
    private $contentType;
    private $contentLength;
    private $body;
    private $isProcessed = false;

    function __construct($data, Request $request, $statusCode = 200, $headers = [])
    {
        parent::__construct(null, $statusCode, $headers);
        $this->data = $data;
        $this->request = $request;
    }

    public function getSupportedAcceptHeaders()
    {
        return [
            'application/x-www-form-urlencoded',
            'application/json',
        ];
    }

    public function getData()
    {
        return $this->data;
    }

    public function getHeaders()
    {
        $this->processData();
        return array_merge(
            parent::getHeaders(),
            [
                'Content-Type' => $this->contentType,
                'Content-Length' => $this->contentLength
            ]
        );
    }

    public function getBody()
    {
        $this->processData();
        return $this->body;
    }

    private function processData()
    {
        if (! $this->isProcessed) {
            $data = $this->getData();
            switch ($this->request->getHeader('Accept'))
            {
                case 'application/x-www-form-urlencoded':
                    $this->contentType = 'application/x-www-form-urlencoded';
                    $data = is_array($data) ? $data : [$data];
                    $this->body = http_build_query($data);
                    break;

                default:
                    $this->contentType = 'application/json';
                    $this->body = json_encode($data, JSON_PRETTY_PRINT);
                    break;
            }
            $this->contentLength = strlen($this->body);
            $this->isProcessed = true;
        };
    }
}