<?php

namespace App\Domains\Models\OAuth;

interface OAuthProvider
{
    public function getState();

    public function getAuthorizationUrl(array $options = []);

    /**
     * @param  mixed $grant
     * @param  array $options
     * @return OAuthAccessToken
     */
    public function getAccessToken($grant, array $options = []);

    /**
     * @param OAuthAccessToken $token
     * @return OAuthOwner
     */
    public function getResourceOwner(OAuthAccessToken $token);
}