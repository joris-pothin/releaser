<?php

namespace App\Client;

use App\Service\Client\AbstractClient;
use App\SongGeneratorDto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SunoClient extends AbstractClient
{
    protected const string PROTOCOL = 'https://';
    private const string BASE_URI = 'studio-api.suno.ai';
    private const string VERSION = 'v2';

    public function __construct(
        protected HttpClientInterface $client,
        protected NormalizerInterface $serializer,
    ) {
        parent::__construct($client, self::BASE_URI, self::VERSION);
    }

    public function generate(SongGeneratorDto $songGeneratorDto): array
    {
        $responseData = $this->post('generate', ['body' => $this->serializer->normalize($songGeneratorDto, 'array')]);

        return $responseData;
    }

    protected function getRoute(string $route, array $params = []): string
    {
        $completeRoute =  self::PROTOCOL.$this->baseUri . '/api/' . $route . '/' . $this->version . '/' . '?';
        foreach ($params as $key => $value) {
            $completeRoute .= $key . '=' . $value . '&';
        }

        return $completeRoute;
    }
}