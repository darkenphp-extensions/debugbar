<?php

namespace Darken\Debugbar;

use DebugBar\StandardDebugBar;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DebugBarMiddleware implements MiddlewareInterface
{
    private StandardDebugBar $debugBar;

    public function __construct()
    {
        $this->debugBar = new StandardDebugBar();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Add a debug message
        // $this->debugBar["messages"]->addMessage("Middleware invoked");

        // Proceed to the next middleware or handler and get the response
        $response = $handler->handle($request);

        // Render the DebugBar assets
        $debugBarRenderer = $this->debugBar->getJavascriptRenderer();

        // Inject the DebugBar head and body scripts into the response
        $body = (string) $response->getBody();

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
