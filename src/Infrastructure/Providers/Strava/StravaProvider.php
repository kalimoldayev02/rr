<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers\Strava;

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

    public function get(string $path, array $query = []): mixed
    {
        try {
            $response = $this->httpClient->request('GET', $path, ['query' => $query]);

            return \json_decode($response->getContent(), flags: JSON_THROW_ON_ERROR);
        } catch (ClientExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|TransportExceptionInterface $e) {
            throw new HttpClientProviderException('[RR<-Strava] ' . $e->getMessage());
        }
    }

    public function post(string $path, object $data, array $query = []): ?\stdClass
    {
        try {
            $response = $this->httpClient->request('POST', $path, ['json' => $data, 'query' => $query]);

            return \json_decode($response->getContent());
        } catch (RedirectionExceptionInterface|TransportExceptionInterface $e) {
            throw new HttpClientProviderException('[RR<-Strava] ' . $e->getMessage());
        } catch (ClientExceptionInterface|ServerExceptionInterface $e) {
            $message = $e->getResponse()->getContent();

            throw new HttpClientProviderException("[RR<-Strava] response (`$path`) error: " . $message, $e->getCode() ?? 0);
        }
    }
}
