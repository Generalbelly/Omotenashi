<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\WhitelistedDomainEntity;
use Log;

class WhitelistedDomainEntityObserver extends EntityObserver
{
    public function creating(WhitelistedDomainEntity $whitelistedDomainEntity)
    {
        $id = $this->generateKey(WhitelistedDomainEntity::class, 'id');
        $whitelistedDomainEntity->setAttribute('id', $id);
    }
}