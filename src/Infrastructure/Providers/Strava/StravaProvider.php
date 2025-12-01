<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers\Strava;

use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Exceptions\TooManyRequestsException;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class StravaProvider
{
    private HttpClientInterface $httpClient;

    public function __construct(
        StravaProviderConfig $config,
        HttpClientInterface $httpClient,
    ) {
        $this->httpClient = $httpClient->withOptions([
            'base_uri' => $config->getApiUtl(),
            'timeout' => $config->getTimeout(),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function withToken(string $token): self
    {
        $clone = clone $this;
        $clone->httpClient = $this->httpClient->withOptions([
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return $clone;
    }

    /**
     * @throws InvalidTokenException
     * @throws TooManyRequestsException
     * @throws HttpClientProviderException
     */
    public function get(string $path, array $query = []): mixed
    {
        try {
            $response = $this->httpClient->request('GET', $path, ['query' => $query]);

            return \json_decode($response->getContent(), flags: JSON_THROW_ON_ERROR);
        } catch (ClientExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|TransportExceptionInterface $exception) {
            if ($exception->getCode() === 401) {
                throw new InvalidTokenException();
            }
            if ($exception->getCode() === 429) {
                throw new TooManyRequestsException();
            }
            throw new HttpClientProviderException('[RR<-Strava] ' . $exception->getMessage());
        }
    }

    /**
     * @throws InvalidTokenException
     * @throws TooManyRequestsException
     * @throws HttpClientProviderException
     */
    public function post(string $path, object $data, array $query = []): ?\stdClass
    {
        try {
            $response = $this->httpClient->request('POST', $path, ['json' => $data, 'query' => $query]);

            return \json_decode($response->getContent());
        } catch (ClientExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|TransportExceptionInterface $exception) {
            if ($exception->getCode() === 401) {
                throw new InvalidTokenException();
            }
            if ($exception->getCode() === 429) {
                throw new TooManyRequestsException();
            }
            throw new HttpClientProviderException('[RR<-Strava] ' . $exception->getMessage());
        }
    }
}
