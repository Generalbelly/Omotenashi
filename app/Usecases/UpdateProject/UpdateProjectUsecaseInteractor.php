<?php

namespace App\Usecases\UpdateProject;

use App\Repositories\Project\ProjectRepositoryContract;

class UpdateProjectUsecaseInteractor implements UpdateProjectUsecase {

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * GetProjectUsecaseInteractor constructor.
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        ProjectRepositoryContract $projectRepository
    ){
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param UpdateProjectRequestModel $request
     * @return UpdateProjectResponseModel
     */
    public function handle(UpdateProjectRequestModel $request): UpdateProjectResponseModel
    {
        $projectEntity = $this->projectRepository->selectOne([
            'domain' => $request->domain,
            'user_id' => $request->userKey,
        ]);
        return new UpdateProjectResponseModel($projectEntity->toArray());
    }

}