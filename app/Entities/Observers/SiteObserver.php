<?php

namespace App\Entities\Observers;

use App\Entities\Site;

class SiteObserver extends Observer
{
    public function creating(Site $site)
    {
        $id = $this->generateKey(Site::class, 'id');
        $site->setAttribute('id', $id);
    }
}