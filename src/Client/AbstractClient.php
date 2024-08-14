<?php

namespace App\Service\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractClient
{
    public function __construct(
        protected HttpClientInterface $client,
        protected string $baseUri,
        protected string $version,
    ) {
    }

    protected function getRoute(string $route, array $params = []): string
    {
        $completeRoute = $this->baseUri . $this->version . '/' . $route . '?';
        foreach ($params as $key => $value) {
            $completeRoute .= $key . '=' . $value . '&';
        }

        return $completeRoute;
    }

    protected function isValidResponse(ResponseInterface $response): bool
    {
        return (in_array($response->getStatusCode(), [200, 203]));
    }

    protected function get(string $route, array $params = []): array
    {
        return $this->request('GET', $this->getRoute($route, $params));
    }

    protected function post(string $route, array $params = []): array
    {
        return $this->request('POST', $this->getRoute($route), $params);
    }

    protected function request($method, string $route, array $params = []): array
    {
        $params['headers'] = array_merge($params['headers'] ?? [], $this->getDefaultHeaders());
        $response = $this->client->request($method, $route, $params);
        if ($this->isValidResponse($response)) {
            return json_decode($response->getContent(), true);
        }

        return [];
    }

    protected function getDefaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}
