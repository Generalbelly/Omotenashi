<?php

namespace App\Domains\Entities\Observers;

use App\Domains\Entities\TutorialStepperEntity;

class TutorialStepperEntityObserver extends EntityObserver
{
    public function creating(TutorialStepperEntityObserver $tutorialStepperEntity)
    {
        $id = $this->generateKey(TutorialStepperEntity::class, 'id');
        $tutorialStepperEntity->setAttribute('id', $id);
    }

}