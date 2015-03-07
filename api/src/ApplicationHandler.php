<?php
namespace Api;

use Api\Web\BadRequestResponse;
use Api\Web\ClientRequest;
use Api\Web\NotAllowedResponse;
use Api\Web\NotAuthenticatedResponse;
use Api\Security\Guard;
use Api\Web\RateLimitedResponse;
use Commando\Web\Request;
use Commando\Web\RequestHandler;
use Pimple\Container;

class ApplicationHandler implements RequestHandler
{
    private $guard;
    private $subHandlers;

    public function __construct(Guard $guard, Container $subHandlers)
    {
        $this->guard = $guard;
        $this->subHandlers = $subHandlers;
    }

    public function handle(Request $request)
    {
        $client = $this->guard->authenticate($request);
        if ($client === null) {
            return new NotAuthenticatedResponse("Must authenticate with HTTP Basic Auth", $request);
        }

        $clientRequest = new ClientRequest($request, $client);
        if ($clientRequest->isOverRateLimit()) {
            return new RateLimitedResponse("Request rate limit exceeded", $clientRequest);
        }
        if ($clientRequest->hasInvalidAuthToken()) {
            return new NotAllowedResponse("Two-factor auth token is invalid", $clientRequest);
        }
        if ($clientRequest->hasParseError()) {
            return new BadRequestResponse('Request body could not be parsed', $clientRequest);
        }

        $router = new ApplicationRouter($this->subHandlers);

        return $router->handle($clientRequest);
    }
}