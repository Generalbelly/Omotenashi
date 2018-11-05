<?php

namespace App\Repositories\Tutorial;

use App\Domains\Entities\TutorialEntity;
use App\Repositories\BaseRepository;

class TutorialRepository extends BaseRepository implements TutorialRepositoryContract
{
    public function __construct(TutorialEntity $tutorialEntity)
    {
        $this->entity = $tutorialEntity;
    }
}