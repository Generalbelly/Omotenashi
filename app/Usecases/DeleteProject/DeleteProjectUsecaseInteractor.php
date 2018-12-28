<?php

namespace App\Usecases\DeleteProject;

use App\Repositories\Project\ProjectRepositoryContract;

class DeleteProjectUsecaseInteractor implements DeleteProjectUsecase {

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
     * @param DeleteProjectRequestModel $request
     * @return DeleteProjectResponseModel
     */
    public function handle(DeleteProjectRequestModel $request): DeleteProjectResponseModel
    {
        $projectEntity = $this->projectRepository->find($request->id);
        foreach ($projectEntity->tutorialEntities as $tutorialEntity) {
            $tutorialEntity->delete();
        }
        $projectEntity->delete();

        return new DeleteProjectResponseModel($projectEntity->toArray());
    }

}