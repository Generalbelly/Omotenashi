<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\GoogleAnalyticsPropertyEntity;


class GoogleAnalyticsPropertyEntityObserver extends EntityObserver
{
    public function creating(GoogleAnalyticsPropertyEntityObserver $googleAnalyticsPropertyEntity)
    {
        $id = $this->generateKey(GoogleAnalyticsPropertyEntityObserver::class, 'id');
        $googleAnalyticsPropertyEntity->setAttribute('id', $id);
    }
}