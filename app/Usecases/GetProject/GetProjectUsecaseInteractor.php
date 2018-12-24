<?php

namespace App\Usecases\GetProject;

use App\Repositories\Project\ProjectRepositoryContract;

class GetProjectUsecaseInteractor implements GetProjectUsecase {

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
     * @param GetProjectRequestModel $request
     * @return GetProjectResponseModel
     */
    public function handle(GetProjectRequestModel $request): GetProjectResponseModel
    {
        $projectEntity = $this->projectRepository->find($request->id);
        return new GetProjectResponseModel($projectEntity->toArray());
    }

}