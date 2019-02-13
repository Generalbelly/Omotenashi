<?php

namespace App\Domains\Models;

interface GoogleApiClient
{
    /**
     * @param string|array $token
     */
    public function setAccessToken($token);

}