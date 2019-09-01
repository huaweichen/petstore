<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiBaseService
{
    /**
     * API base uri.
     * @var string
     */
    public $baseUri;

    /**
     * API `api_key`
     * @var string
     */
    public $secret;

    /**
     * Send a request to consume other service.
     *
     * @param string $method
     * @param string $requestUri
     * @param array $formParam
     * @param array $headers
     * @return string
     * @throws GuzzleException
     */
    public function send(string $method, string $requestUri, array $formParam = [], array $headers = []): string
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if (isset($this->secret)) {
            $headers['api_key'] = $this->secret;
        }

        $response = $client->request($method, $requestUri, ['form_params' => $formParam, 'headers' => $headers]);

        return $response->getBody()->getContents();
    }
}
