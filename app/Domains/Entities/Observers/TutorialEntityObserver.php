<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\TutorialEntity;
use Ramsey\Uuid\Uuid;
use Log;

class TutorialEntityObserver extends EntityObserver
{
    public function creating(TutorialEntity $tutorialEntity)
    {
        $id = $this->generateKey(TutorialEntity::class, 'id');
        $tutorialEntity->setAttribute('id', $id);
    }

}