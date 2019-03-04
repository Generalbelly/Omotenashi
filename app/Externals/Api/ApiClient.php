<?php

namespace App\Externals\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

use App\Domains\Entities\OAuthEntity;

abstract class ApiClient
{
    const BASE_URL = '';
    protected $accessToken;
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    protected function getAbsoluteUrl($path)
    {
        return sprintf('%s/%s', static::BASE_URL, $path);
    }

    protected function request(string $path, $options=[])
    {
        try {
            $url = $this->getAbsoluteUrl($path);
            $response = $this->client->get($url, $options);
            $result = json_decode($response->getBody()->getContents(), true);
            return $result;
        } catch (RequestException $e) {
            \Log::error($e->getMessage());
            throw $e;
        }
    }
}