<?php

namespace App\Externals\Google;

use App\Externals\Api\ApiClient;

class GoogleAnalyticsClient extends ApiClient
{
    const BASE_URL = 'https://www.googleapis.com/analytics/v3/management';

    public function listAccountSummaries()
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept'        => 'application/json',
            ]
        ];
        $response = $this->request('accountSummaries', $options);
        $summaries = $response['items'];
        return $summaries;
    }

    public function setAccessToken(string $token)
    {
        $this->accessToken = $token;
    }
}