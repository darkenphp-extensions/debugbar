<?php

namespace Darken\Debugbar;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DebugBarMiddleware implements MiddlewareInterface
{
    public function __construct(protected DebugBarConfig $debugBar)
    {

    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $debugBar = $this->debugBar;

        if (!$debugBar->isActive) {
            return $handler->handle($request);
        }

        // Render the DebugBar assets
        $debugBarRenderer = $debugBar->getJavascriptRenderer();
        $debugBarRenderer->setBaseUrl('/assets/debugbar');

        $this->debugBar->start('app', 'Application Request');

        $this->debugBar->message("Middleware invoked with request: " . $request->getUri());

        // Proceed to the next middleware or handler and get the response
        $response = $handler->handle($request);

        // Inject the DebugBar head and body scripts into the response
        $body = (string) $response->getBody();

        $this->debugBar->stop('app');

        $headInjection = $debugBarRenderer->renderHead();
        $bodyInjection = $debugBarRenderer->render();

        $body = preg_replace(
            '/<head>/i',
            "<head>\n{$headInjection}",
            $body
        );

        $body = preg_replace(
            '/<\/body>/i',
            "{$bodyInjection}\n</body>",
            $body
        );

        // Create a new response with the modified body
        $response = $response->withBody(stream_for($body));


        return $response;
    }
}

// Helper function to create a stream
function stream_for(string $content): \Psr\Http\Message\StreamInterface
{
    $stream = fopen('php://temp', 'r+');
    fwrite($stream, $content);
    rewind($stream);
    return new \Nyholm\Psr7\Stream($stream);
}
