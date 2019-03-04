<?php

namespace App\Domains\Models;

interface GoogleAnalyticsClient
{
    public function setAccessToken(string $token);
    public function listAccountSummaries();
}