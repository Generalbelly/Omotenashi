<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\SiteEntity;

class SiteEntityObserver extends EntityObserver
{
    public function creating(SiteEntity $siteEntity)
    {
        $id = $this->generateKey(SiteEntity::class, 'id');
        $siteEntity->setAttribute('id', $id);
    }
}