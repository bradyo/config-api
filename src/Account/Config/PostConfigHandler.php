<?php
namespace Api;

use JsonSchema\Validator;

class PostConfigHandler
{
    private $configValidator;
    private $configStorage;

    public function __construct($configStorage)
    {
        $this->configValidator = new Validator();
        $this->configStorage = $configStorage;
    }

    public function handle(Api $request)
    {
        $payload = $request->getData();

        $schemaId = $payload["schemaId"];
        $schema = file_get_contents(__DIR__ . '/../../data/sample-schema.json');

        $configData = $payload["data"];

        $this->configValidator->check($configData, $schema);
        if (! $this->configValidator->isValid()) {
            return new BadRequestResponse("Config data is invalid", $this->configValidator->getErrors());
        }

        $accountId = $request->getClient()->getAccount()->getId();

        $config = new Config($accountId, $configData);
        $savedConfig = $this->configStorage->save($config);

        $href = $savedConfig->getHref();
        $data = $this->mapper->toData($savedConfig);

        return new LocationResponse($href, $data, $request);
    }
}