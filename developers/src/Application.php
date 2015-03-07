<?php
namespace Developers;

use Commando\Web\TextResponse;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Commando\Web\RequestHandler;
use Commando\Web\Request;

class Application extends \Commando\Application implements RequestHandler
{
    public function __construct($cachingEnabled = true)
    {
        parent::__construct();
        $this->setWebRequestHandler($this);

        $options = [];
        if ($cachingEnabled) {
            $options = ['cache' => __DIR__ . '/../cache'];
        }
        $this->twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/../views'), $options);
    }

    public function handle(Request $request)
    {
        $pages = [
            'authentication',
            'response-codes',
            'media-types',
            'collections',
            'rate-limits',
            'endpoints',
            'account-endpoints',
            'config-endpoints',
            'consumer-endpoints'
        ];
        $page = 'not-found.twig';
        if ($request->getUri() === '/') {
            $page = 'index.twig';
        }
        else if (preg_match('/^\/(.+)\/?/', $request->getUri(), $matches)) {
            $targetPage = $matches[1];
            if (in_array($targetPage, $pages)) {
                $page = $targetPage . '.twig';
            }
        }
        $html = $this->twig->render($page);

        return new TextResponse($html);
    }
}