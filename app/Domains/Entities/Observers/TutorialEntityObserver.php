<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\TutorialEntity;

class TutorialEntityObserver extends EntityObserver
{
    public function creating(TutorialEntity $tutorialEntity)
    {
        $id = $this->generateKey(TutorialEntity::class, 'id');
        $tutorialEntity->setAttribute('id', $id);
    }

}