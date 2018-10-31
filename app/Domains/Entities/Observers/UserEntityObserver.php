<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\UserEntity;

class UserEntityObserver extends EntityObserver
{
    public function creating(UserEntity $userEntity)
    {
        $key = $this->generateKey(UserEntity::class, 'key');
        $userEntity->setAttribute('key', $key);
    }
}