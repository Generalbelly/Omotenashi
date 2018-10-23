<?php

namespace App\Entities\Observers;

use App\Entities\GAOAuth;

class GAOAuthObserver extends Observer
{
    public function creating(GAOAuth $ga_oauth)
    {
        $id = $this->generateKey(GAOAuth::class, 'id');
        $ga_oauth->setAttribute('id', $id);
    }
}