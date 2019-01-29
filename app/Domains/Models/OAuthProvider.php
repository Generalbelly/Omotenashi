<?php

namespace App\Domains\Models;

interface OAuthProvider
{
    public function getState();

    public function getAuthorizationUrl(array $options = []);

    public function getAccessToken($grant, array $options = []);

    public function getResourceOwner(AccessToken $token);
}