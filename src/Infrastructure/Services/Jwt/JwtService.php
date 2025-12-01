<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Jwt;

use App\Domain\Entities\AccessTokenEntity;
use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Exceptions\Auth\TokenExpiredException;
use App\Domain\Services\Jwt\JwtServiceInterface;
use App\Domain\ValueObjects\IdVO;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class JwtService implements JwtServiceInterface
{
    public function __construct(
        private JwtConfig $jwtConfig,
    ) {}

    public function generateAccessToken(UuidInterface $userId): AccessTokenEntity
    {
        $id = new IdVO()->getValue();
        $issuedAt = \time();
        $expiration = $issuedAt + $this->jwtConfig->get('ttl');

        $payload = [
            'iss' => $id,
            'iat' => $issuedAt,
            'exp' => $expiration,
            'sub' => $userId->toString(),
        ];

        $token = JWT::encode(
            payload: $payload,
            key: $this->jwtConfig->get('secret'),
            alg: $this->jwtConfig->get('algorithm'),
        );

        return new AccessTokenEntity(
            id: $id,
            userId: $userId,
            token: $token,
            expiresAt: new \DateTimeImmutable("@$expiration"),
        );
    }

    public function decodeAccessToken(string $accessToken): AccessTokenEntity
    {
        try {
            $decoded = JWT::decode(
                jwt: $accessToken,
                keyOrKeyArray: new Key($this->jwtConfig->get('secret'), $this->jwtConfig->get('algorithm')),
            );

            return new AccessTokenEntity(
                id: Uuid::fromString($decoded->iss),
                userId: Uuid::fromString($decoded->sub),
                token: $accessToken,
                expiresAt: new \DateTimeImmutable("@{$decoded->exp}"),
            );
        } catch (ExpiredException) {
            throw new TokenExpiredException();
        } catch (BeforeValidException|\Exception $exception) {
            throw new InvalidTokenException($exception->getMessage());
        }
    }
}
