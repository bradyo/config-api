<?php
namespace Api\Schema;

use Api\Security\AuthenticatedRequest;

/**
 * @WebRoute("/schemas")
 */
class SchemaHandler
{
    private $eTagCache;
    private $schemaStorage;

    public function __construct(SchemaStorage $schemaStorage)
    {
        $this->schemaStorage = $schemaStorage;
        $this->eTagCache = new \Memcache();
    }

    public function handle(AuthenticatedRequest $request)
    {


    }
}