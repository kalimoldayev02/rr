<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Middlewares;

use App\Infrastructure\Framework\Exceptions\Handler;
use App\Infrastructure\Framework\Exceptions\Renderer\ApiJsonRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final readonly class ApiErrorHandlerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Handler $handler,
        private ApiJsonRenderer $renderer,
        private ResponseFactoryInterface $responseFactory,
        private LoggerInterface $logger,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getFile(), [
                'message' => $exception->getMessage(),
                'uri' => (string) $request->getUri(),
                'method' => $request->getMethod(),
            ]);

            $statusCode = $this->handler->getHttpStatusCode($exception);

            $body = $this->renderer->render(exception: $exception);

            $response = $this->responseFactory->createResponse($statusCode);
            $response->getBody()->write($body);

            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}
