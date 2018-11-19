<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\ProjectEntity;

class ProjectEntityObserver extends EntityObserver
{
    public function creating(ProjectEntity $projectEntity)
    {
        $id = $this->generateKey(ProjectEntity::class, 'id');
        $projectEntity->setAttribute('id', $id);
    }
}