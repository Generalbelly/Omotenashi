<?php

namespace App\Repositories\TutorialPath;

use App\Domains\Entities\TutorialPathEntity;
use App\Repositories\BaseRepository;

class TutorialPathRepository extends BaseRepository implements TutorialPathRepositoryContract
{
    public function __construct(TutorialPathEntity $tutorialPathEntity)
    {
        parent::__construct($tutorialPathEntity);
    }
}