<?php

namespace App\Domains\Models;

use League\OAuth2\Client\Provider\Google;

interface OAuthProvider
{
    public function getState();

    public function getAuthorizationUrl(array $options = []);

    public function getAccessToken($grant, array $options = []);

    public function getResourceOwner(OAuthAccessToken $token);
}