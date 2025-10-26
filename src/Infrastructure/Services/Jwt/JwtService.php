<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Jwt;

use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Exceptions\Auth\TokenExpiredException;
use App\Domain\Services\Auth\JwtServiceInterface;
use App\Domain\ValueObjects\TokenVO;
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

    public function generateAccessToken(UuidInterface $userId): TokenVO
    {
        $issuedAt = \time();
        $expiration = $issuedAt + $this->jwtConfig->get('ttl');

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expiration,
            'sub' => $userId->toString(),
        ];

        $token = JWT::encode(
            payload: $payload,
            key: $this->jwtConfig->get('secret'),
            alg: $this->jwtConfig->get('algorithm'),
        );

        return new TokenVO(
            token: $token,
            expiresAt: new \DateTimeImmutable("@$expiration"),
        );
    }

    public function validateAccessToken(string $token): array
    {
        try {
            $decoded = JWT::decode(
                jwt: $token,
                keyOrKeyArray: new Key($this->jwtConfig->get('secret'), $this->jwtConfig->get('algorithm')),
            );

            return (array) $decoded;
        } catch (ExpiredException $e) {
            throw new TokenExpiredException();
        } catch (BeforeValidException | \Exception $e) {
            throw new InvalidTokenException($e->getMessage());
        }
    }

    public function getAthleteIdFromToken(string $token): UuidInterface
    {
        $payload = $this->validateAccessToken($token);

        if (!isset($payload['sub']) || !\is_string($payload['sub'])) {
            throw new InvalidTokenException('Invalid token payload');
        }

        try {
            return Uuid::fromString($payload['sub']);
        } catch (\Exception $e) {
            throw new InvalidTokenException('Invalid athlete ID in token');
        }
    }
}
