<?php

namespace App\Entities\Observers;

use App\Entities\User;

class UserObserver extends Observer
{
    public function creating(User $user)
    {
        $key = $this->generateKey(User::class, 'key');
        $user->setAttribute('key', $key);
    }
}