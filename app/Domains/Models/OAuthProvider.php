<?php

namespace App\Domains\Models;

interface OAuthProvider {

    public function getAuthorizationUrl(array $options = []): string;

    public function getState(): string;

    public function getAccessToken($grant, array $options = []): OauthToken;

    public function getResourceOwner(OauthToken $token): OauthOwner;

}