<?php
namespace Api\Web;

class LocationResponse extends ClientResponse
{
    private $href;

    function __construct($href, $data, ClientRequest $request)
    {
        parent::__construct($data, $request, 201);
        $this->href = $href;
    }

    public function getHeaders()
    {
        return array_merge(parent::getHeaders(), ['Location' => $this->href]);
    }
}