<?php
namespace Api;

class ConfigGetHandler
{
    public function __construct(ConfigFinder $finder)
    {
        $this->finder = $finder;
    }

    public function handle(Api $request)
    {
        $name = $request->getData()['name'];

        $config = $this->finder->find($name);
        if ($config === null) {
            return new NotFoundResponse("Config not found");
        }

        $eTag = md5($config->getId());
        if ($request->getHeader('If-None-Match') === $eTag) {
            return new NotModifiedResponse();
        }

        $data = $this->mapper->toData($config);
        $dataResponse = new DataResponse($data, $request);

        return new ETagResponse($dataResponse, $eTag);
    }
}