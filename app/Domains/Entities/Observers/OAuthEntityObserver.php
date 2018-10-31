<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\OAuthEntity;

class OAuthEntityObserver extends EntityObserver
{
    public function creating(OAuthEntity $oauthEntity)
    {
        $id = $this->generateKey(OAuthEntity::class, 'id');
        $oauthEntity->setAttribute('id', $id);
    }
}