<?php

namespace App\Repositories\TutorialStep;

use App\Domains\Entities\TutorialStepEntity;
use App\Repositories\BaseRepository;

class TutorialStepRepository extends BaseRepository implements TutorialStepRepositoryContract
{
    public function __construct(TutorialStepEntity $tutorialStepEntity)
    {
        parent::__construct($tutorialStepEntity);
    }
}