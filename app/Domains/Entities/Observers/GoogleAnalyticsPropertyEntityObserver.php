<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\GoogleAnalyticsPropertyEntity;

class GoogleAnalyticsPropertyEntityObserver extends EntityObserver
{
    public function creating(GoogleAnalyticsPropertyEntity $googleAnalyticsPropertyEntity)
    {
        $id = $this->generateKey(GoogleAnalyticsPropertyEntity::class, 'id');
        $googleAnalyticsPropertyEntity->setAttribute('id', $id);
    }
}