<?php

namespace App\Domains\Models\OAuth;

interface OAuthOwner {

    public function getId();

    public function getEmail(): string;

    public function toArray(): array;
    
}