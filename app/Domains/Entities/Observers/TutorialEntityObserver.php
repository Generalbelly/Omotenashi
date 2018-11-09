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

    public function saving(TutorialEntity $tutorialEntity)
    {
        $steps = [];
        foreach ($tutorialEntity->steps as $step) {
            if (!isset($step['id'])) {
                do {
                    $uuidObject = Uuid::uuid4();
                    $uuid = $uuidObject->toString();

                    $duplicate = false;
                    foreach ($tutorialEntity->steps as $s) {
                        if (isset($s['id'])) {
                            $duplicate = $s['id'] === $uuid;
                        }
                    }
                } while ($duplicate);
                $step['id'] = $uuid;
            }
            $steps[] = $step;
        }
        $tutorialEntity->setAttribute('steps', $steps);
    }
}