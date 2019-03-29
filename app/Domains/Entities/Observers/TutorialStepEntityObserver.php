<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\TutorialStepEntity;

class TutorialStepEntityObserver extends EntityObserver
{
    public function creating(TutorialStepEntity $tutorialStepEntity)
    {
        $id = $this->generateKey(TutorialStepEntity::class, 'id');
        $tutorialStepEntity->setAttribute('id', $id);
    }
}