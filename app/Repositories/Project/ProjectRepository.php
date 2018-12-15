<?php

namespace App\Repositories\Project;

use App\Domains\Entities\ProjectEntity;
use App\Repositories\BaseRepository;

class ProjectRepository extends BaseRepository implements ProjectRepositoryContract
{
    /**
     * ProjectRepository constructor.
     * @param ProjectEntity $projectEntity
     */
    public function __construct(ProjectEntity $projectEntity)
    {
        parent::__construct($projectEntity);
    }
}