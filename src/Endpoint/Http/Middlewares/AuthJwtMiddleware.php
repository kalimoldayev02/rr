<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Middlewares;

use App\Domain\Repositories\AccessTokenRepositoryInterface;
use App\Domain\Services\Jwt\JwtServiceInterface;
use App\Endpoint\Http\Contexts\UserContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spiral\Http\Exception\ClientException\UnauthorizedException;
use Spiral\Core\ScopeInterface;

final readonly class AuthJwtMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ScopeInterface $scope,
        private JwtServiceInterface $jwtService,
        private AccessTokenRepositoryInterface $accessTokenRepository,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (empty($authHeader)) {
            throw new UnauthorizedException('Authorization header is missing');
        }
        if (!\str_starts_with($authHeader, 'Bearer')) {
            throw new UnauthorizedException('Invalid authorization header format');
        }

        $accessTokenEntity = $this->jwtService->decodeAccessToken(\substr($authHeader, 7));
        if ($this->accessTokenRepository->isRevoked(id: $accessTokenEntity->getId())) {
            throw new UnauthorizedException('Access token is revoked');
        }

        return $this->scope->runScope([
            UserContext::class => new UserContext($accessTokenEntity->getUserId(), $accessTokenEntity),
        ], static function () use ($handler, $request) {
            return $handler->handle($request);
        });
    }
}
