<?php
namespace Api\Schema;

/**
 * @WebRoute("GET /{id}")
 */
class SchemaGetHandler
{
    private $eTagCache;
    private $schemaStorage;

    public function __construct(SchemaStorage $schemaStorage)
    {
        $this->schemaStorage = $schemaStorage;
        $this->eTagCache = new \Memcache();
    }

    public function handle(SchemaGetRequest $request)
    {
        $eTagKey = $request->getETagCacheKey();
        $eTag = $this->eTagCache->get($eTagKey);
        if ($eTag !== false && $request->getHeader('If-None-Matched') === $eTag) {
            return new NotModifiedResponse();
        }

        $id = $request->getId();
        $schema = $this->schemaStorage->get($id);
        if ($schema === null) {
            return new NotFoundResponse("Schema not found");
        }

        $schemaResponse = new SchemaResponse($schema);
        $eTag = $schema->getId();
        $this->eTagCache->set($eTagKey, $eTag);

        return new ETagResponse($schemaResponse, $eTag);
    }
}