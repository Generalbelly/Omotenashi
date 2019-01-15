<?php

namespace App\Domains\Models;

interface OAuthOwner {

    public function getId();

    public function getEmail(): string;

    public function toArray(): array;
    
}