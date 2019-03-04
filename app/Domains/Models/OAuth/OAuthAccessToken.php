<?php

namespace App\Domains\Models\OAuth;

interface OAuthAccessToken
{
    public function getToken();

    public function getRefreshToken();

    public function getExpires();

    public function getResourceOwnerId();

    public function hasExpired();

    public function getValues();

    public function jsonSerialize();
}