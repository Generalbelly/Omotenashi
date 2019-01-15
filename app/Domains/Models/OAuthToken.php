<?php

namespace App\Domains\Models;

interface OAuthToken {

    public function getRefreshToken(): string;

    public function getToken(): string;

}